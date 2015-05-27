<?php
namespace GCWorld\Menu\PanelElements;

class LoginForm
{
    private $parent         = null;

    /**
     * todo: set this to null.  currently set to facilitate legacy code.
     * @var string
     */
    protected $loginUrl     = '/login_resp.php';
    protected $forgotUrl    = '/lostpass.php';

    /**
     * @param $parent
     */
    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param $url
     */
    public function setLoginURL($url)
    {
        $this->loginUrl = $url;
        return $this;
    }

    /**
     * @param $url
     */
    public function setForgotURL($url)
    {
        $this->forgotUrl = $url;
        return $this;
    }


    /**
     * @return string
     */
    public function returnButton()
    {
        return '
			<form class="form-horizontal" method="post" action="'.$this->loginUrl.'">
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
							<a class="btn btn-danger" href="'.$this->forgotUrl.'">Forgot Password?</a>
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
