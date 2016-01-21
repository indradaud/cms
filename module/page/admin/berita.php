
<?php 

use Landingo\Resources\Date; 
use Landingo\Resources\Dbase;
use Landingo\Resources\File;
use Landingo\Resources\Pagination;

$db = new Dbase();

Date::set(array('length' => 3));

function getSeoLink($str)
{
    $prefix = str_replace(' ', '-', substr(trim($str), 0, 50));
    $fixed = filter_var(strtolower($prefix), FILTER_SANITIZE_URL);

    return $fixed;
}

switch ($this->_act) : 

default : ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li class="active">Berita</li>
</ol>

<div class="page-header">
    <h2>Managemen Berita</h2>
</div>

<?php

//pagination
$active_page = 1;

if($this->_act === 'page' && isset($this->_params[0]))
{
    $active_page = $this->_params[0];
}

$paging = new Pagination(array(
    'base_url' => $base_url . '/index.php/admin/berita/page',
    'active_page' => $active_page,
    'max' => 15,
    'data_total' => $db->get('berita')->rowCount()
));

$pages = $paging->pages();

$db->limit = $paging->limit($active_page);
$db->join = 'INNER JOIN';
$db->joined_table = 'kategori';
$db->references = 'berita.kategori_id = kategori.id';
$db->order_by = 'timestamp DESC';
$data = $db->get('berita')->resultAll();

?>

<table class="table table-striped table-hover">
  <thead>
      <tr>
          <th width="40px">#</th>
          <th width="160px">Hari, Tanggal</th>
          <th width="170px">Kategori</th>
          <th width="500px" style="text-align:left">Judul</th>
          <th width="80px">Dibaca</th>
          <th width="140px">Tindakan</th>
      </tr>
  </thead>
  <tbody>

      <?php $no = $paging->dataNumbering(); ?>

      <?php foreach($data as $berita) : ?>

      <tr>
          <td><?=$no?></td>
          <td><?=Date::convert($berita->timestamp)?></td>
          <td><?=$berita->kategori?></td>
          <td style="text-align:left"><?=$berita->judul?></td>
          <td><?=$berita->dibaca?> kali</td>
          <td>
            <a href="<?=$base_url?>/index.php/admin/berita/edit/<?=$berita->seolink?>" class="text-warning">
              <span class="fa fa-pencil-square-o"></span>Edit
            </a>
            <a href="<?=$base_url?>/index.php/admin/berita/hapus/<?=$berita->seolink?>" class="text-danger">
              <span class="fa fa-times-circle-o"></span>Hapus
            </a>
          </td>
      </tr>

      <?php $no++; ?>
      <?php endforeach; ?>
  </tbody>
</table>

<div class="pull-left">
    <a href="<?=$base_url?>/index.php/admin/berita/tulis" class="btn btn-info btn-sm">
        <span class="fa fa-pencil"></span> 
        Tulis Berita
    </a>
</div>

<div class="pull-right" style="margin-bottom:10px">

<nav>
<ul class="pagination pagination-sm" style="margin:0">

<?php

$prev = array(
    'status' => 'disabled',
    'link' => '#'
);
$next = array(
    'status' => 'disabled',
    'link' => '#'
);

if(isset($pages['prev']))
{
    $prev['status'] = null;
    $prev['link'] = $pages['prev'];
}

if(isset($pages['next']))
{
    $next['status'] = null;
    $next['link'] = $pages['next'];
}

?>

    <li class="<?=$prev['status']?>">
        <a href="<?=$prev['link']?>" aria-label="Previous">
            <span aria-hidden="true">&laquo; Prev</span>
        </a>
    </li>

    <?php for($i = 1; $i <= $pages['total']; $i++) : ?>

    <?php if($i == $active_page) : ?>
        <li class="active"><a href="#"><?=$i;?></a></li>
    <?php else : ?>
        <li><a href="<?=$pages['link'] .'/'. $i; ?>"><?=$i?></a></li>
    <?php endif; ?>

    <?php endfor; ?>

    <li class="<?=$next['status']?>">
        <a href="<?=$next['link']?>" aria-label="Next">
            <span aria-hidden="true">Next &raquo;</span>
        </a>
    </li>
</ul>
</nav>

</div>


<?php break; ?>

<?php case 'tulis' : ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li><a href="<?=$base_url?>/index.php/admin/berita">Berita</a></li>
    <li class="active">Tulis Berita</li>
</ol>

<div class="page-header">
    <h2>Tulis Berita</h2>
</div>

<?php

$form_data = array('judul' => null, 'kategori' => null, 'isi_berita' => null);

if(isset($_SESSION['form_data']))
{
    $form_data = $_SESSION['form_data'];
    unset($_SESSION['form_data']);
}

$kategori = $db->get('kategori')->resultAll();

?>

<form method="post" action="<?=$base_url?>/index.php/admin/berita/publikasikan" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
        <label for="judul" class="col-sm-2 control-label">Judul</label>
        <div class="col-sm-8">
            <input type="text" name="judul" class="form-control" value="<?=$form_data['judul']?>">
        </div>
    </div>
    <div class="form-group">
        <label for="kategori" class="col-sm-2 control-label">Kategori</label>
        <div class="col-sm-8">
            <select name="kategori" class="form-control">
                <option value="">Pilih Kategori</option>

                <?php foreach($kategori as $kat) : ?>
                <?php if($kat->id === $form_data['kategori']) : ?>
                <option value="<?=$kat->id?>" selected><?=$kat->kategori?></option>
                <?php else : ?>
                <option value="<?=$kat->id?>"><?=$kat->kategori?></option>
                <?php endif;?>
                <?php endforeach; ?>

            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="sampul" class="col-sm-2 control-label">Sampul Berita</label>
        <div class="col-sm-8">
            <input type="file" name="sampul" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="isi_berita" class="col-sm-2 control-label">Isi Berita</label>
        <div class="col-sm-8">
            <textarea name="isi_berita" rows="18" class="form-control" style="resize:none"><?=$form_data['isi_berita']?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-8">
            <input type="submit" name="form_send" class="btn btn-success btn-sm" value="Publikasikan">
        </div>
    </div>
</form>


<?php break; ?>

<?php case 'publikasikan' : ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li><a href="<?=$base_url?>/index.php/admin/berita">Berita</a></li>
    <li class="active">Publikasikan</li>
</ol>

<div class="page-header">
    <h2>Publikasikan Berita</h2>
</div>

<?php

$error = 0;

if(!isset($_POST['form_send']))
{
  echo '<div class="alert alert-danger" role="alert">';
  echo "Kesalahan ditemukan ! Anda belum menulis berita !";
  echo '</div>';

    $error++;
}

$form_data = array('judul' => null, 'kategori' => null, 'isi_berita' => null);

foreach ($_POST as $key => $value) 
{

    $form_data["{$key}"] = $_POST["{$key}"];

    if(empty($_POST["{$key}"]))
    {
        echo '<div class="alert alert-danger" role="alert">';
        echo "Kesalahan ditemukan ! Form <b>{$key}</b> kosong !";
        echo '</div>';

        $error++;
    }
}



if($error)
{
    $_SESSION['form_data'] = $form_data;

    echo "<a href='{$base_url}/index.php/admin/berita/tulis'>&larr; Kembali ke form</a>";

} else
{

$sampul = $_FILES['sampul'];

File::upload('img/berita', $sampul);

$file = File::$filename;

$seolink = getSeoLink($form_data['judul']);

$data = array('', 
              $form_data['kategori'], 
              $_SESSION['cms_logged_userid'],
              time(), 
              $form_data['judul'],
              $form_data['isi_berita'],
              $file,
              0,
              $seolink
);

$run = $db->insert('berita', $data)->rowCount();

if($run)
{

    echo '<div class="alert alert-success" role="alert">';
    echo "Berita berhasil dipublikasikan !";
    echo '</div>';

    echo "<a href='{$base_url}/index.php/admin/berita'>&larr; Kembali ke managemen berita</a>";
}

}

?>

<?php break; ?>

<?php case 'edit' : ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li><a href="<?=$base_url?>/index.php/admin/berita">Berita</a></li>
    <li class="active">Edit</li>
</ol>

<div class="page-header">
    <h2>Edit Berita</h2>
</div>

<?php if(!isset($this->_params[0])) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Tidak ada berita yang dipilih !
</div>
<a href='<?=$base_url?>/index.php/admin/berita'>&larr; Kembali ke managemen berita</a>

<?php return; ?>
<?php endif;?>


<?php

$seolink = $this->_params[0];

$db->where = "seolink = '{$seolink}'";
$berita = $db->get('berita')->result();

$db->reset(array('where'));

?>

<?php if(!$berita) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Tidak ada berita yang dipilih !
</div>
<a href='<?=$base_url?>/index.php/admin/berita'>&larr; Kembali ke managemen berita</a>

<?php return; ?>
<?php endif;?>

<?php

$kategori = $db->get('kategori')->resultAll();

?>

<form method="post" action="<?=$base_url?>/index.php/admin/berita/perbarui" enctype="multipart/form-data" class="form-horizontal">

    <input type="hidden" name="id_berita" value="<?=$berita->id?>">

    <div class="form-group">
        <label for="judul" class="col-sm-2 control-label">Judul</label>
        <div class="col-sm-8">
            <input type="text" name="judul" class="form-control" value="<?=$berita->judul?>">
        </div>
    </div>
    <div class="form-group">
        <label for="kategori" class="col-sm-2 control-label">Kategori</label>
        <div class="col-sm-8">
            <select name="kategori" class="form-control">

                <?php foreach($kategori as $kat) : ?>
                <?php if($kat->id === $berita->kategori_id) : ?>
                <option value="<?=$kat->id?>" selected><?=$kat->kategori?></option>
                <?php else : ?>
                <option value="<?=$kat->id?>"><?=$kat->kategori?></option>
                <?php endif;?>
                <?php endforeach; ?>

            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="sampul" class="col-sm-2 control-label">Sampul Berita</label>
        <div class="col-sm-8">
            <input type="file" name="sampul" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="isi_berita" class="col-sm-2 control-label">Isi Berita</label>
        <div class="col-sm-8">
            <textarea name="isi_berita" rows="18" class="form-control" style="resize:none"><?=$berita->isi?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-8">
            <input type="submit" name="form_send_update" class="btn btn-success btn-sm" value="Perbarui">
            <a href="<?=$base_url?>/index.php/admin/berita" class="btn btn-warning btn-sm">Batal</a>
        </div>
    </div>
</form>

<?php break; ?>

<?php case 'perbarui' : ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li><a href="<?=$base_url?>/index.php/admin/berita">Berita</a></li>
    <li class="active">Perbarui</li>
</ol>

<div class="page-header">
    <h2>Perbarui Berita</h2>
</div>

<?php if(!isset($_POST['form_send_update']) || !isset($_POST['id_berita'])) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Tidak ada berita yang di edit !
</div>
<a href='<?=$base_url?>/index.php/admin/berita'>&larr; Kembali ke managemen berita</a>

<?php return;?>
<?php endif;?>


<?php

$data = array('kategori_id' => $_POST['kategori'],
              'judul' => $_POST['judul'],
              'isi' => $_POST['isi_berita']
);

$db->where = "id = {$_POST['id_berita']}";
$run = $db->update('berita', $data)->rowCount();

$db->reset(array('where'));

?>

<?php if($run) : ?>

<div class="alert alert-success">
Berita berhasil diperbarui !
</div>

<a href='<?=$base_url?>/index.php/admin/berita'>&larr; Kembali ke managemen berita</a>

<?php endif; ?>

<?php break; ?>

<?php case 'hapus': ?>

<ol class="breadcrumb">
    <li><a href="<?=$base_url?>/index.php/admin">Dashboard</a></li>
    <li><a href="<?=$base_url?>/index.php/admin/berita">Berita</a></li>
    <li class="active">Hapus</li>
</ol>

<div class="page-header">
    <h2>Hapus Berita</h2>
</div>

<?php if(!isset($this->_params[0])) : ?>

<div class="alert alert-danger">
Kesalahan ditemukan ! Tidak ada berita yang dihapus !
</div>
<a href='<?=$base_url?>/index.php/admin/berita'>&larr; Kembali ke managemen berita</a>

<?php return;?>
<?php endif;?>

<?php

$seolink = $this->_params[0];

$db->where = "seolink = '{$seolink}'";

$db->row = 'gambar';
$g = $db->get('berita')->result();

File::delete('img/berita', $g->gambar);

$run = $db->delete('berita')->rowCount();
$db->reset(array('where'));

?>

<?php if($run) : ?>

<div class="alert alert-success">
Berita berhasil di hapus !
</div>
<a href='<?=$base_url?>/index.php/admin/berita'>&larr; Kembali ke managemen berita</a>

<?php endif; ?>

<?php break; ?>

<?php endswitch; ?>

<?php $db->close();?>