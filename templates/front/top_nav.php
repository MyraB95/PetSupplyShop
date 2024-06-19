<style>
    .navbar {
        background-color: #343a40; /* Dark grey background color */
        border: none; /* Remove any border */
    }

    .navbar-nav {
        margin: 0 auto;
        display: table; /* Center alignment */
        float: none; /* Clear any float */
    }
</style>

<div class="container">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">HOME</a>
        </div>
        <div class="collapse navbar-collapse text-center" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="shop.php" style="color: #FFA500;">SHOP</a>
                </li>
                <?php if (!isset($_SESSION["loggedin"])) : ?>
                    <li>
                        <a href="login.php" style="color: #FFA500;">Login</a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="checkout.php" style="color: #FFA500;">Checkout</a>
                </li>
                <li>
                    <a href="contact.php" style="color: #FFA500;">Contact</a>
                </li>
                <?php if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === true) : ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #FFA500;">Admin <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="admin" style="color: #FFA500;">Admin Panel</a></li>
                            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
                                <li><a href="logout.php" style="color: #FFA500;">Logout</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>
