<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');

$memo_php2 = formatBytes(memory_get_usage())."<br>";// 23.81M
$memo_php = formatBytes(memory_get_usage(), 0)."<br>";// 24M
//echo formatBytes(memory_get_usage(), 4);// 23.8061M
?>
<style type="text/css">
  table {
    font-family: 'OCR A Extended';
    border-collapse: collapse;
    border: 0;
    width: 100%;
    box-shadow: 1px 2px 3px #ccc;
  }

  .center {
    text-align: center;
  }

  .center table {
    margin: 1em auto;
    text-align: left;
  }

  .center th {
    text-align: center !important;
  }

  td,
  th {
    border: 1px solid #666;
    font-size: 90%;
    vertical-align: baseline;
    padding: 4px 5px;
  }

  h1 {
    font-size: 150%;
  }

  h2 {
    font-size: 125%;
  }

  .p {
    text-align: left;
  }

  .e {
    background-color: #F5F5DC;
    width: 300px;
    font-weight: bold;
  }

  .h {
    background-color: #99c;
    font-weight: bold;
  }

  .v {
    background-color: #DCDCDC;
    max-width: 300px;
    overflow-x: auto;
    word-wrap: break-word;
  }

  .v i {
    color: #999;
  }
</style>
<div class="panel">
  <div class="panel-header">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#Informasi" data-toggle="tab">Info Sistem</a></li>
      <li><a href="#histori" data-toggle="tab">Histori</a></li>
      <li ><a href="#listcache" data-toggle="tab">Lish Cache</a></li>
    </ul>
  </div>
  <div class="panel-body">
    <div class="tab-content">
      <div class="tab-pane active" id="Informasi">
        <div class="panel">
          <div class="panel-body">
            <table>
              <tr>
                <td class="e">Versi CBT </td>
                <td class="v"><?= APLIKASI . VERSI . ' '.REVISI ?></td>
              </tr>
              <tr>
                <td class="e">Webserver </td>
                <td class="v"><?= $_SERVER['SERVER_SOFTWARE']; ?></td>
              </tr>
              <tr>
                <td class="e">Versi PHP </td>
                <td class="v"><?= phpversion(); ?></td>
              </tr>
              <tr>
                <td class="e">Memory Yang Digunakan Oleh PHP </td>
                <td class="v"><?= $memo_php2 ?></td>
              </tr>
              <tr>
                <td class="e">Database </td>
                <td class="v"><?= mysqli_get_server_info($koneksi); ?></td>
              </tr>
              <tr>
                <td class="e">Satatus Cache | Versi Cache </td>
                <td class="v">
                  <?php
                  try {
                      $Redis->ping();
                      echo('Aktif');
                  } catch (Exception $e) {
                      if($e->getMessage()){
                        echo('Tidak Aktif');
                      }
                  }
                  echo' | ';
                  try {
                    foreach ($Redis->info() as $value) {
                      echo $value['redis_version'];
                    }

                  } catch (Exception $e) { }
                ?>
                </td>
              </tr>
              <tr>
                <td class="e">Sistem Operasi </td>
                <td class="v"><?php echo php_uname('a'); ?></td>
              </tr>
              <?php
              $ua = getBrowser();
              $yourbrowser = $ua['name'] . " " . $ua['version'];
              ?>
              <tr>
                <td class="e">Browser </td>
                <td class="v"><?= $yourbrowser ?></td>
              </tr>
              <tr>
                <td class="e">Owner</td>
                <td class="v">Nasha Arumi</td>
              </tr>
              <tr>
                <td class="e">Tim Candy </td>
                <td class="v">Batman The Dark Knight | DKK</td>
              </tr>
              <tr>
                <td class="e">Web Candy </td>
                <td class="v"><a href="https://cbtcandy.com/">https://cbtcandy.com/</a> || <a href="https://www.youtube.com/channel/UCWwotNPs4H7sW8t_g8yb1sg" target="_blank"><b>Youtube Chanel Candy</b></a></td>
              </tr>
              <tr>
                <td class="e">MOD Versi</td>
                <td class="v">@mryes OPS KW || <a href="https://www.youtube.com/@opskw8081" target="_blank"><b>Youtube Chanel</b></a> || Lampung Timur</td>
              </tr>
              <tr>
                <td class="e">Aplikasi Lainya Tidak Kalah Menarik</td>
                <td class="v"><a href="https://codeteam.id" target="_blank">https://codeteam.id</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="histori">
        <div class="panel-body">

          <?php
          $file_histori = "histori.txt";
          if (file_exists($file_histori)) {
            $fh = fopen($file_histori, "r");

            while (true) {
              $line = fgets($fh);
              if ($line == null) break;

              echo $line . "<br>";
            }

            fclose($fh);
          } else {
            echo "Tidak ada histori";
          }
          ?>
        </div>
      </div>
      <div class="tab-pane" id="listcache">
        <?php
        foreach ($db->RedisKeys() as $key) {
          echo $key.'<br>';
        }
        ?>
      </div>
    </div>
  </div>
</div>