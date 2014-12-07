<?php
namespace GCWorld\Menu;

class PanelElements_LoginForm
{
	private $parent         = null;

	public function __construct($parent)
	{
		$this->parent = $parent;
	}


	/**
	 * @return string
	 */
	public function returnButton()
	{
		return '
			<form class="form-horizontal" method="post" action="/login_resp.php">
				<fieldset>
					<legend>Login</legend>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" name="username" placeholder="Username" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password" class="form-control" name="password" placeholder="Password" required>
					</div>
					<div class="control-group">
						<label class="control-label" for="button1id"></label>
						<div class="controls">
							<input type="submit" class="btn btn-success" value="Login">
							<a class="btn btn-danger" href="/lostpass.php">Forgot Password?</a>
						</div>
					</div>
				</fieldset>
			</form>
		';
	}

	/**
	 * @return \GCWorld\Menu\MenuBlock
	 */
	public function getParent()
	{
		return $this->parent;
	}

}
