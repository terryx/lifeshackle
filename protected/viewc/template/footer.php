<div id="footer"></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/js/twitter-bootstrap/bootstrap-all.js"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/common.js?v1"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.validationEngine.js?v1"></script>
<script type="text/javascript" src="<?php echo $data['baseurl']; ?>global/min/jquery.paginate.js?v1"></script>
<?php if(!empty($data['customscript'])): ?>
	<script type="text/javascript" src="<?php echo $data['baseurl'].$data['customscript']; ?>"></script>
<?php endif; ?>