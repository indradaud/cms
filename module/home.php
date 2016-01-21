<?php 

use Landingo\Resources\Dbase;


$db = new Dbase();

$kategori = $db->get('kategori')->resultAll();

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>CMS Administrator</title>
    <link rel="stylesheet" href="<?=$base_url?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$base_url?>/assets/awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=$base_url?>/assets/css/style.css">
    <script src="<?=$base_url?>/assets/js/jquery.min.js"></script>
    <script src="<?=$base_url?>/assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<div id="container" class="col-sm-10 col-sm-offset-1" style="margin-top:3em">

<header>
<div class="col-sm-8 col-sm-offset-2">
<h1 class="text-center"><span class="fa fa-newspaper-o"></span> News</h1>
<form>

<div class="input-group">
    <input type="text" class="form-control" placeholder="Cari berita">
    <span class="input-group-addon" id="basic-addon"><i class="glyphicon glyphicon-search"></i></span>
</div>
</form>

<ul class="nav nav-pills" style="margin:20px 0 5px">

<?php foreach($kategori as $k) : ?>
<li><a href="#"><?=$k->kategori;?></a></li>
<?php endforeach;?>
</ul>

</div>
<div class="clearfix"></div>

</header>

<div id="content">
<?php $this->loadPage() ?>
</div>

</div>

</body>
</html>