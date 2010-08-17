<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>KoGit 1.0</title>
		<link href="{$path}media/css/kogit.css" type="text/css" rel="stylesheet" media="screen" charset="utf-8" />
		<script src="{$path}media/js/kogit.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="login">
			<form method="post" action="{$path}login">
				<fieldset>
					<legend>{"Login"|__}</legend>
					<dl>
						<dt><label for="_login_email">{"Email"|__}</label></dt>
							<dd><input type="text" name="email" id="_login_email" /></dd>
						<dt><label for="_login_password">{"Password"|__}</label></dt>
							<dd><input type="password" name="password" id="_login_password" /></dd>
					</dl>
					<input type="submit" name="login" value="{"Login"|__}" id="_login_submit" />
				</fieldset>
			</form>
		</div>
	</body>
</html>