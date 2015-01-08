<?php
session_start();

if (isset($_GET['logout'])) {
    $_SESSION = array();
}

require_once 'MultisocialApi.php';

$publicKey = '';  // api public key
$privateKey = ''; // api private key
$secretKey = '';  // api secret key

$multiSocial = new MultisocialApi($publicKey, $privateKey, $secretKey);

$data = $multiSocial->getUserData();

?>

<?php if ($data): ?>
    <?php if (isset($data['id'])): ?>
        <p>
            <?php echo 'Hello, ' . $data['first_name'] . ', ' . $data['last_name']; ?>
        </p>
        <p>
            <?php echo 'You have logged in from ' . $data['platform']; ?>
        </p>
        <a href="./?logout">logout</a>
    <?php else: ?>
        <?php echo key($data) . ': ' . $data['error']['details']; ?>
    <?php endif; ?>
<?php else: ?>
    <!-- Iframe goes here -->
<?php endif;?>
