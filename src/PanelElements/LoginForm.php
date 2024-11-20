<?php
namespace GCWorld\Menu\PanelElements;

use GCWorld\Menu\MenuBlock;

/**
 * LoginForm Class
 */
class LoginForm
{
    protected MenuBlock $parent;

    protected ?string $loginUrl     = null;
    protected ?string $forgotUrl    = null;

    /**
     * @param MenuBlock $parent
     */
    public function __construct(MenuBlock $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setLoginURL(string $url): static
    {
        $this->loginUrl = $url;
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setForgotURL(string $url): static
    {
        $this->forgotUrl = $url;
        return $this;
    }


    /**
     * @return string
     */
    public function returnButton(): string
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
     * @return MenuBlock
     */
    public function getParent(): MenuBlock
    {
        return $this->parent;
    }
}
