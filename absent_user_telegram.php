include "../custom/config.php";

$path = "https://api.telegram.org/bot[token Bot]/";
$update = json_decode(file_get_contents("php://input"), TRUE);

//get data user
$chatId = $update["message"]["chat"]["id"];
$chatType = $update["message"]["chat"]["type"];
$chatName = isset($update["message"]["chat"]["title"]) ? $update["message"]["chat"]["title"] : $update["message"]["chat"]["first_name"] . " " . $update["message"]["chat"]["last_name"];
$chatUsername = isset($update["message"]["chat"]["username"]) ? $update["message"]["chat"]["username"] : null;

//cek and save user to DB, then get id users
$cek_users = $conn->query("select * from absensi_user_telegram where chat_id = '" . $chatId . "'");

if($cek_users->num_rows == 0)
{
    $post_users = $conn->query("insert into absensi_user_telegram (chat_id,type,name,username)
    values
    ('" . $chatId . "',
    '" . $chatType . "',
    '" . $chatName . "',
    '" . $chatUsername . "' )");

    if($post_users == true)
    {
        $users_id = $conn->insert_id;
    }
}
elseif ($cek_users->num_rows == 1)
{
    $cek_users = $cek_users->fetch_assoc();
    $users_id = $cek_users['id'];
}
