/*
CREATE TABLE short_urls (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    slug VARCHAR(50) NOT NULL
);
*/
//数据库创建命令

public function get_short_url( $url, $post_id ) {
      $servername = "";
      $username = "";
      $password = "";
      $dbname = "";
      $shorturl = "";//填写Sink的域名

      $conn = new mysqli($servername, $username, $password, $dbname);
      
      $sql = "SELECT slug FROM short_urls WHERE url = '$url'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          // 如果存在对应的slug，则获取该slug
          $row = $result->fetch_assoc();
          $slug = $row['slug'];
          return $shorturl.$slug;
      } else {
          // 如果不存在对应的slug，则继续进行下一步操作，比如生成新的slug
          // 在这里添加生成新的slug的代码逻辑
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $slug = '';
          for ($i = 0; $i < 5; $i++) {
              $slug .= $characters[rand(0, strlen($characters) - 1)];
          }
          
          $api_url = "https://shortlink.fz.do/api/link/create";
              // 定义要请求的URL和请求头
          $headers = array(
              "authorization: Bearer pw",//修改为自己的
              "content-type: application/json"
          );
          $data = json_encode(array("url" => $url, "slug" => $slug));
          
          // 发起POST请求
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $api_url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $response = curl_exec($ch);
          curl_close($ch);
          $responseData = json_decode($response, true);
          // 获取返回的slug和URL
          
          // 将slug记录在数据库中
          $sql = "INSERT INTO short_urls (url, slug) VALUES ('$url', '$slug')";
          $conn->query($sql);
          
          // 关闭数据库连接
          $conn->close();
          return $shorturl.$slug;
      }

}
