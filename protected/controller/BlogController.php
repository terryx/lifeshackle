<?php

class ArticleController extends CommonController {

  public function manageArticlePage() {
    $menu = self::assignMenu();
    $this->renderc('/manage-article', $menu);
  }

  public function saveArticle() {
    Doo::loadCore('helper/DooValidator');

    //check if user exist before proceed
    if (!$_SESSION['user']['username']) {
      $this->toJSON('Only authorized personel can access this page', true);
      return 404;
    }

    //create a new article if id is not defined
    if (empty($_POST['article_id'])) {

      $rules = array(
          'title' => array('required', 'Title must not empty'),
          'txtcontent' => array('required', 'Content must not empty')
      );

      $v = new DooValidator();
      $v->checkMode = DooValidator::CHECK_SKIP;

      //error if validate fail
      $err = $v->validate($_POST, $rules);
      if ($err) {
        $this->toJSON($err, true);
        return 400;
      }

      //insert latest id
      $latest_update_array = array(
          'type' => 'article'
      );

      Doo::loadModel('LatestUpdate');
      $la = new LatestUpdate($latest_update_array);
      $last_insert_id = $la->insert();

      $article = array(
          'title' => $this->xss($_POST['title']),
          'created' => strftime("%Y-%m-%d %H:%M:%S", time()),
          'body' => wordwrap($_POST['txtcontent'], 90),
          'tag' => $this->xss($_POST['tag']),
          'user_id' => $_SESSION['user']['id'],
          'latest_id' => $last_insert_id
      );

      Doo::loadModel('Article');
      $a = new Article($article);
      $a->insert();

      $this->toJSON(array('Article has created successfully', 'Create Success'), true);
      return 201;
    }//end create
    //edit article with existing post id
    if (!empty($_POST['article_id']) && intval($_POST['article_id']) > 0) {

      $rules = array(
          'title' => array('required', 'Title must not empty'),
          'txtcontent' => array('required', 'Content must not empty')
      );

      $v = new DooValidator();
      $v->checkMode = DooValidator::CHECK_SKIP;

      $err = $v->validate($_POST, $rules);
      if ($err) {
        $this->toJSON($err, true);
        return 400;
      } else {
        $article = array(
            'article_id' => $this->xss($_POST['article_id']),
            'title' => $this->xss($_POST['title']),
            'body' => wordwrap($_POST['txtcontent'], 90),
            'tag' => $this->xss($_POST['tag']),
            'user_id' => $_SESSION['user']['id'],
        );
        Doo::loadModel('Article');
        $a = new Article($article);
        $a->update();

        $this->toJSON(array($this->xss($_POST['title']) . ' has been edited', 'Update Success'), true);
        return 200;
      }
    }//end edit
    //throw error page if non condition matched
    return 404;
  }

  public function getArticleList() {
    $rs = $this->db()->find('Article', array('select' =>
                'article_id as k0,
					 title as k1,
					 created as k2',
                'desc' => 'created'));
    $this->toJSON($rs, true, true);
  }

  public function getOneArticle() {
    if (!$this->params['id'] || intval($this->params['id']) < 1) {
      return 404;
    } else {
      Doo::loadModel('Article');
      $a = new Article();
      $a->article_id = $this->params['id'];
      $rs = $a->getOne();

      if ($rs) {
        $this->toJSON($rs, true, true);
      } else {
        $this->toJSON('Article not found', true);
        return 400;
      }
    }
  }

  public function getArticle() {

    $sql = 'SELECT article.title as k0, DATE_FORMAT(article.created, "%D %M %Y") as k1,
            article.body as k2, article.tag as k3, users.username as k4 FROM article, users
             WHERE article.user_id = users.id ORDER BY article.created DESC';
    $rs = $this->db()->fetchAll($sql);

    $this->toJSON($rs, true, true);
  }

  public function deleteArticle() {

    //get article
    $a = $this->db()->find('Article', array(
       'limit' => 1,
        'where' => 'article.article_id = ?',
        'param' => array(intval($this->params['id']))
    ));

    if ($a->count()) {
      //get latest id
      $la = $this->db()->find('LatestUpdate', array(
                  'limit' => 1,
                  'where' => 'latest_update.latest_id = ?',
                  'param' => array($a->latest_id)
              ));

      $a->beginTransaction();
      $la->beginTransaction();
      try {
        $a->delete();
        $la->delete();
        $a->commit();
        $this->toJSON(array('deleted'), true);
      } catch (PDOException $e) {
        $a->rollBack();
        return 500;
      }
    } else {
      return 404;
    }
  }

}

?>
