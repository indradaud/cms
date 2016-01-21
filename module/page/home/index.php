<?php 

use Landingo\Resources\Date; 
use Landingo\Resources\Dbase;


$db = new Dbase();

Date::set(array('length' => 3));

$db->row = 'berita.judul, berita.timestamp, berita.gambar, berita.seolink, kategori.kategori, users.nama as oleh';
$db->many_join = array(
    'kategori' => 'berita.kategori_id=kategori.id',
    'users' => 'berita.user_id=users.id'
);
$db->order_by = 'timestamp DESC';

$news = $db->get('berita')->resultAll();

?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>">Home</a></li>
    <li class="active">Semua Berita</li>
</ol>

<?php foreach ($news as $berita): ?>

<div class="col-sm-6 col-md-4">
    <div class="thumbnail" style="height:450px">
      <img src="<?=$base_url?>/img/berita/<?=$berita->gambar?>" alt="...">
      <div class="caption">
        <p class="text-warning article-info">
            <span class="fa fa-calendar"></span><?=Date::convert($berita->timestamp)?>
        </p>
        <p class="text-warning article-info">
            <span class="fa fa-link"></span><?=$berita->kategori?>
        </p>
        <p class="text-warning article-info">
            <span class="fa fa-user"></span><?=$berita->oleh?>
        </p>
        <h3><?=$berita->judul?></h3>
        <p class="selengkapnya">
            <a href="<?=$base_url?>/index.php/baca/<?=$berita->seolink?>" class="text-info">Baca selengkapnya &rarr;</a>
        </p>
      </div>
    </div>
  </div>


<?php endforeach; ?>

