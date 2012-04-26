var Login = {
	start: function start(){
		var self = this, login;
		
		$.ajax({
			type: 'GET',
			url: '/login',
			beforeSend: function(){
				$main.html('');
				Loader.show();
			},
			success: function(data){
				if(data){
					Loader.remove();
					$main.append(data);
					
					self.ready(login);
				}
			}
		});
	},
	setting: function setting(){
		var login = {
			form: $('#login-form'),
			username: $('#username').val(),
			password: $('#password').val()
		};
		
		return login;
	},
	ready: function ready(){
		var self = this, login;
		
		$('#login-form').bind('submit', function(e){
			e.preventDefault();
			
			login = self.validate();
			console.log(login)
			if(login !== 400){
				window.location = '/'+ login;
			}
		});
		
	},
	validate: function validate(login, callback){
		
		var self = this;
		var username = self.setting().username, password = self.setting().password;
		var ok;
		
		if(username === ''){
			Alert.message('Please enter username', 'error');
			return 400;
		}
			
		if(password === ''){
			Alert.message('Please enter password', 'error');
			return 400;
		} else {
			
			$.ajax({
				type: 'POST',
				url: '/login/process-login',
				data: {
					username:username, 
					password:password
				},
				success: function(data){
					if(data){
						callback(data);
					} else {
						Alert.message('Invalid username/password', 'error');
						callback(400);
					}
				}
			});
		}
	}
}

