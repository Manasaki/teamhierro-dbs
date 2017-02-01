<?php
include('function.php');
cpSession();
$editsynopsis = $_GET['editsynopsis'];
$uploadepisode = $_GET['uploadepisode'];
?>
<html>
<head>
<title>Admin Panel</title>
<style type="text/css">
label{
    display: inline-block;
    float: left;
    clear: left;
    width: 150px;
    text-align: left;
}
input, textarea {
  display: inline-block;
  float: left;
}
</style>
</head>
<?php
cpAdminPanel();
if ((isset($editsynopsis)) && ($editsynopsis == 'true'))
{
	cpAdminPanelSynopsis();
}

if ((isset($uploadepisode)) && ($uploadepisode == 'true'))
{
	cpAdminPanelUpload();
}

?>
</html>
