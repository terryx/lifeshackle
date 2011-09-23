<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="robots" content="noodp,noydir" />
    <meta name="description" content="Lifeshackle is a social blog which promotes and shares technology news and philosophy of life to everyone." />
    <meta name="keywords" content="Lifeshackle, Life, Shackle of Life, terryxlife, social news, personal blog" />
    <meta name="author" content="Terry Yuen Wai Hoe" />
    <link rel="shortcut icon" href="global/img/x.png" />
    <link rel="stylesheet" href="global/css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="global/css/jquery-ui.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="global/css/validation/validationEngine.jquery.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="global/css/alert/jquery.alerts.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="global/css/blk-form.css" type="text/css" media="screen" />

    <style>
      /*  ul {
           width:100px;
           margin-right: 10px;

        }
        ul li {
          display:none;

        }
        .indicator {
          padding: 2px 0 5px 5px;
          background: url(global/img/scroll-down.png) no-repeat 95% 45%;
        }*/
      <div class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
      <div class="facebook"><iframe src="http://www.facebook.com/plugins/like.php?locale=en_US&href='+location.href+'&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:23px;" allowTransparency="true"></iframe></div>

    </style>

    <?php $this->renderc('template/head-end'); ?>
    <?php $this->renderc('template/a-nav'); ?>
  <div id="container">
    <div id="main-content">
      <div id="progress"></div>

      <!--	<div class="positionable">
          <p>
	to position
	</p>
      </div>-->



      <!--    <div id="menux">

            <ul style="list-style: none;cursor: pointer;margin-right: 10px">

              <div class="indicator">Manage</div>
              <li><a href="home">Article</a></li>
              <li><a href="#">User</a></li>
              <li><a href="#">Picture</a></li>
            </ul>
             <ul style="list-style: none;cursor: pointer">Manage

              <li><a href="#">Article</a></li>
              <li><a href="#">User</a></li>
              <li><a href="#">Picture</a></li>
            </ul>

          </div>
        </div>-->


      <div class="menu">
        <div class="indicator">Manage</div>

        <a href="google.com">Manage G</a>
        <a href="google.com">Manage a</a>
        <a href="google.com">Manage b</a>
        <a href="google.com">Manage c</a>


      </div>

      <!-- <div class="menu">
          <div class="indicator">Manage</div>

            <a href="google.com">Manage G</a>
             <a href="google.com">Manage a</a>
             <a href="google.com">Manage b</a>
              <a href="google.com">Manage c</a>



        </div>
       <div class="menu">
          <div class="indicator">Manage</div>

            <a href="google.com">Manage G</a>
             <a href="google.com">Manage a</a>
             <a href="google.com">Manage b</a>
              <a href="google.com">Manage c</a>



        </div>-->
    </div>

    <div id="footer">
	This is footer
    </div>
    <!--<script type="text/javascript" src="http://terryxlife.com/js/jquery.js"></script>-->
    <script type="text/javascript" src="global/js/jquery.js"></script>
    <script type="text/javascript" src="global/js/jquery-ui.js"></script>

    <script type="text/javascript" src="global/js/common.js"></script>
    <!-- <script type="text/javascript" src="global/js/jquery.ui.menu.js"></script>-->
    <!-- <script type="text/javascript" src="global/js/jquery.ui.menubar.js"></script>-->
    <script type="text/javascript">
      $(function(){

        //		$("#menux > ul").menu({
        //
        //          create : toggleMenu
        //		});
        setMenu();
        function setMenu(){
          $('.menu').mouseover(function(){
            $(this).children('a').css('display', 'block');

          });

          $('.menu').mouseout(function(){
            $(this).children('a').css('display', 'none');
          });
        }

        function toggleMenu(){
          $(this).mouseover(function() {
            $(this).children('li').show();

          });
          $(this).mouseout(function() {
            $(this).children('li').hide();
          });
        }
        $('#loader').remove();



      }); //end document ready


    </script>
  </body>
</html>
