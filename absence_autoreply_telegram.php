//jika user id tersedia
if (isset($users_id) && isset($update["message"]["text"]))
{
    $message = $update["message"]["text"];
    $send_at_str = $update["message"]["date"];
    $send_at = date("Y-m-d H:i:s", $send_at_str);

    //cek text yang dikirimkan di tabel autoreply
    $cek_ar = $conn->query("select * from absensi_autoreply_telegram where keyword = '" . $message . "'");
if($cek_ar->num_rows == 1)
{
    $cek_ar = $cek_ar->fetch_assoc();
    $ar_id = $cek_ar['id'];
    $ar_ans = $cek_ar['answer'];
    $ar_ans_url = urlencode($ar_ans);

    //input ke db untuk history chat
    $post_ar = $conn->query("insert into absensi_chat_telegram
    (absensi_user_telegram_id,
    text,
    send_at_str,
    send_at,absensi_autoreply_telegram_id,answer)
    values
    ('" . $users_id . "',
    '" . $message . "',
    '" . $send_at_str . "',
    '" . $send_at . "',
    '" . $ar_id . "',
    '" . $ar_ans . "')");
if ($post_ar == true)
{
    //cek dan send ke semua group jika user absen tidak hadir
    $getgroup = $conn->query("select * from absensi_user_telegram where type = 'group'");
    if(($getgroup->num_rows > 0) && ($ar_id > 3))
    {
        $group_chat = $getgroup->fetch_all(MYSQLI_ASSOC);
        foreach ($group_chat as $key)
        {
            file_get_contents($path . "/sendmessage?chat_id=" . $key['chat_id'] . "&text=Absen " . $message . " : " . $chatName);
        }
    }
}
else
{
    $cek_ar = $conn->query("select * from absensi_autoreply_telegram where keyword = 'start'");
    $cek_ar = $cek_ar->fetch_assoc();
    $ar_id = $cek_ar['id'];
    $ar_ans = $cek_ar['answer'];
    $ar_ans_url = urlencode($ar_ans);
}

file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=Hai " . $chatName . ", " . $ar_ans_url);
