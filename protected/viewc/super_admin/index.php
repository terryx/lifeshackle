<?php $this->renderc('template/head-start'); ?>
<title>Life Shackle- Super Admin Home</title>
<?php $this->renderc('template/head-end'); ?>
<?php $this->renderc('template/a-nav'); ?>
<div id="container">
  <div id="main-content">
    <div id="progress"></div>
    <?php $this->renderc('template/master-menu'); ?>
    <div class="content">
      <div class="blog_box">
        <h2>First Blog post</h2>
        This is 1st post.
      </div>
      <form id="article_form" class="green-form">

        <label for="article_name">Title</label>
        <input type="text" id="article_name" name="article_name" class="title" /></br>
        <label for="tag">Tag</label>
        <select name="tag">
          <option value="">Please select a tag</option>
        </select></br></br>
        <textarea id="body" name="body" rows="10" cols="70" placeholder="Type your content here.."></textarea>
        </br>
        <input type="submit" value="Post" />

      </form>
    </div>
  </div>

  <div id="side-content">
    <div class="content">
      This is side content

    </div>
  </div>
</div>
<?php $this->renderc('template/footer'); ?>
<script type="text/javascript">
  $(function(){
$('#nav a:eq(0)').addClass('active');
    $('#article_form').submit(function(){
      $.post('article/create_article', $(this).serialize(),
      function(data){
        console.log(data);
      });
      return false;
    });

    $('#loader').remove();

  });
</script>
</body>
</html>