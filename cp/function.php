<?php

function cpDatabase()
{
	$link = mysqli_connect('localhost', 'teamhier_dbs', 'B8:!j>cX$Cd7q${~', 'teamhier_cp');
	if (!$link)
	{
		echo '<strong>Critical-Error</strong>: Unable to connect to the database teamhier_cp.';
	}
	else
	{
		return $link;
	}
}

function synopsisDatabase()
{
	$link = mysqli_connect('localhost', 'user', 'pass', 'db name');
	if (!$link)
	{
		echo '<strong>Critical-Error</strong>: Unable to connect to the database: teamhier_dbs.';
	}
	else
	{
		return $link;
	}
}

function cpIsLoggedIn()
{
	if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))
	{
		$link = cpDatabase();
		$username = htmlspecialchars(stripslashes(trim(mysqli_real_escape_string($link, $_POST['username']))));
		$password = htmlspecialchars(stripslashes(trim(mysqli_real_escape_string($link, $_POST['password']))));
		$query = "SELECT * FROM `cp_users` WHERE `username` = '$username' AND `password` = '$password'";
		if ($result = mysqli_query($link, $query) or die(mysqli_error($link)))
		{
			if ($row = mysqli_num_rows($result) > 0)
			{
				while ($row = mysqli_fetch_row($result))
				{
					$_SESSION['username'] = htmlspecialchars(stripslashes(trim(mysqli_real_escape_string($link, $row[1]))));
					$_SESSION['valid'] = true;
				}

				if ($_SESSION['valid'] = true)
				{
					echo 'You are logged in as <strong>' . $_SESSION[username] . '</strong>. You have access to:<br/>';
					echo '<br/><a href="admin.php?editsynopsis=true">Admin Panel</a>';
					echo '<br/><a href="http://www.teamheirro.com/dbs/community">Forums</a>';
					echo '<br/><a href="logout.php">Logout</a>';
				}
				else
				{
					mysqli_free_result($result);
				}
			}
			else
			{
				echo 'That username/password combination is incorrect. Redirecting to login page.';
				cpKillSession();
				header('Refresh:3 index.php');
				exit;
			}
		}
	}
	else
	{
		cpLoginForm();
	}
}

function cpLoginForm()
{
	echo '
	<form action="index.php" method="post">
	<h4>THCP - Login</h4>
	<label>Username:</label> <input type="text" name="username" placeholder="username"><br />
	<label>Password:</label> <input type="password" name="password" placeholder="password"><br />
	<label></label><input type="submit" name="login">
	</form>';
}

function cpSession()
{
	ob_start();
	session_start();
	ob_end_flush();
}

function cpKillSession()
{
	session_unset($_SESSION['username']);
	session_unset($_SESSION['valid']);
}

function cpLogout()
{
	session_unset($_SESSION['username']);
	session_unset($_SESSION['valid']);
	header("Refresh:2; index.php");
	exit;
}

function cpAdminPanel()
{
	if (($_SESSION['valid']) == true)
	{
		echo '<h1>Team Hierro Admin Panel</h1><hr/>';
		echo 'You are able to manage the following:<br>';
		echo '<a href="admin.php?editsynopsis=true">| Synopsis |</a>';
		echo '<a href="admin.php?uploadepisode=true"> Upload Episode |</a>';
	}
}

function cpAdminPanelUpload()
{
	if(isset($_FILES['episode']))
	{
		$errors= array();
		$file_name = $_FILES['episode']['name'];
		$file_size =$_FILES['episode']['size'];
		$file_tmp =$_FILES['episode']['tmp_name'];
		$file_type=$_FILES['episode']['type'];   
		$file_ext=strtolower(end(explode('.',$_FILES['episode']['name'])));
		$expensions= array("mp4");
		$error = true;

		if(in_array($file_ext,$expensions)=== false)
		{
			echo "extension not allowed, please choose a MP4 file.";
			$error = false;
		}

		if($error == true)
		{
			move_uploaded_file($file_tmp,"../../../dbs/resources/media/".$file_name);
			echo "Success";
		}
	}
	cpAdminPanelUploadForm();
}

function cpAdminPanelUploadForm()
{
	echo '<div>
	<form action="admin.php?uploadepisode=true" method="post" enctype="multipart/form-data">
	<label><h4>Choose File</h4></label>
	<label><input type="file" name="uploadepisode" id="uploadepisode"></label>
	<label></label><input type="submit" name="uploadfile">
	</form>
	</div>';
}

function cpAdminPanelSynopsis()
{
	if (isset($_POST['addsynopsis']) && $_POST['addsynopsis'] == 'Submit')
		{
			if (isset($_POST['synopsis']) && !empty($_POST['synopsis']))
			{
				if ($_POST['synopsis'] == 'delete')
				{
					if (!isset($_POST['episodenumber']) || empty($_POST['episodenumber']))
					{
						$error = true;
					}
					else
					{
						$link = synopsisDatabase();
						$episodenumber = htmlspecialchars(stripslashes(trim(mysqli_real_escape_string($link, $_POST['episodenumber']))));
						$query = "SELECT * FROM `synopsis` WHERE `id` = '$episodenumber'";
						if ($result = mysqli_query($link, $query) or die(mysqli_error($link)))
						{
							if ($row = mysqli_num_rows($result) > 0)
							{
								$query = "DELETE FROM `synopsis` WHERE `id` = '$episodenumber'";
								if ($result = mysqli_query($link, $query) or die(mysqli_error($link)))
								{
									if ($row = mysqli_num_rows($result) == 0)
									{
										echo '<h3>You have deleted the following data from the Database:</h3>';
										echo '<strong>Episode:</strong> ' . $episodenumber;
									}
								}
							}
						}
					}
				}

				if ($_POST['synopsis'] != 'delete')
				{
					if (!isset($_POST['episodenumber']) || empty($_POST['episodenumber']))
					{
						echo 'You need to enter an <strong>episode number</strong><br/>';
						$error = true;
					}

					if (!isset($_POST['title']) || empty($_POST['title']))
					{
						echo 'You need to enter a <strong>title</strong><br/>';
						$error = true;
					}

					if (!isset($_POST['datereleased']) || empty($_POST['datereleased']))
					{
						echo 'You need to enter a <strong>date released</strong><br/>';
						$error = true;
					}

					if (!isset($_POST['synopsisinput']) || empty($_POST['synopsisinput']))
					{
						echo 'You need to enter a <strong>synopsis</strong><br/>';
						$error = true;
					}

					if ($error == false)
					{
						$error = false;
						$link = synopsisDatabase();
						$episodenumber = mysqli_real_escape_string($link,htmlspecialchars(stripslashes(trim($_POST['episodenumber']))));
						$title = mysqli_real_escape_string($link,htmlspecialchars(stripslashes(trim($_POST['title']))));
						$datereleased = mysqli_real_escape_string($link,htmlspecialchars(stripslashes(trim($_POST['datereleased']))));
						$synopsisinput = mysqli_real_escape_string($link,htmlspecialchars(stripslashes(trim($_POST['synopsisinput']))));
						
						if ($_POST['synopsis'] == 'add')
						{
							if (!is_numeric($episodenumber))
							{
								echo 'You will need to use a number for Episode Numbers';
							}
							else
							{
								$query = "SELECT * FROM `synopsis` WHERE `id` = '$episodenumber'";
								if ($result = mysqli_query($link, $query) or die(mysqli_error($link)))
								{
									if ($row = mysqli_num_rows($result) > 0)
									{
										echo 'There is an synopsis for that Episode arleady.';
									}
									else
									{
										$query = "INSERT INTO `synopsis` (id, title, date, synopsis) VALUES ('$episodenumber', '$title', '$datereleased', '$synopsisinput')";
										if ($result = mysqli_query($link, $query) or die(mysqli_error($link)))
										{
											echo '<h3>You have added the following data to the Database:</h3>';
											echo '<strong>Episode:</strong> ' . $episodenumber;
											echo '<br /><strong>Title:</strong> ' . $title;
											echo '<br /><strong>Date Released:</strong> ' . $datereleased;
											echo '<br /><strong>Synopsis:</strong> ' . $synopsisinput;
										}
									}
								}
							}
						}

						if ($_POST['synopsis'] == 'update')
						{
							$link = synopsisDatabase();
							$episodenumber = mysqli_real_escape_string($link,htmlspecialchars(stripslashes(trim($_POST['episodenumber']))));
							$title = mysqli_real_escape_string($link,htmlspecialchars(stripslashes(trim($_POST['title']))));
							$datereleased = mysqli_real_escape_string($link,htmlspecialchars(stripslashes(trim($_POST['datereleased']))));
							$synopsisinput = mysqli_real_escape_string($link,htmlspecialchars(stripslashes(trim($_POST['synopsisinput']))));
							$query = "SELECT * FROM `synopsis` WHERE `id` = '$episodenumber'";
							if ($result = mysqli_query($link, $query) or die(mysqli_error($link)))
							{
								if ($row = mysqli_num_rows($result) > 0)
								{
									$query = "UPDATE `synopsis` SET `title`='$title', `date`='$datereleased',`synopsis`='$synopsisinput' WHERE `id` = '$episodenumber'";
									if ($result = mysqli_query($link, $query) or die(mysqli_error($link)))
									{
										if ($row = mysqli_num_rows($result) == 0)
										{
											echo '<h3>You have Updated the following data from the Database:</h3>';
											echo '<strong>Episode:</strong> ' . $episodenumber;
											echo '<br /><strong>Title:</strong> ' . $title;
											echo '<br /><strong>Date Released:</strong> ' . $datereleased;
											echo '<br /><strong>Synopsis:</strong> ' . $synopsisinput;
										}
									}
								}
							}
						}
					}
				}
			}

			if (!isset($_POST['synopsis']) || empty($_POST['synopsis']))
			{
				echo 'You need to choose a <strong>CRUD</strong> option.<br/>';
				$error = true;
			}
		} else {
			cpAdminPanelSynopsisForm();
		}
}

function cpAdminPanelSynopsisForm()
{
	echo '<div>
	<form action="admin.php?editsynopsis=true" method="post">
	<label><h4>Synopsis Information</h4></label>
	<label>Episode #: </label> <input type="text" name="episodenumber" placeholder="1"><br />
	<label>Title: </label> <input type="text" name="title" placeholder="Who Gets the 100,000,000 Zeni?"><br />
	<label>Date Released: </label> <input type="text" name="datereleased" placeholder="January 31, 2017"><br />
	<label>Synopsis: </label><textarea name=synopsisinput rows="4" cols="50" placeholder=" After Son Goku defeated the dangerous Majin Boo, peace has returned to Earth once again. Chi-Chi wants Goku to get a job, so he works as a farmer."></textarea><br />
	<label>Add Synopsis</label></label><input type="radio" name="synopsis" value="add">
	<label>Delete Synopsis</label><input type="radio" name="synopsis" value="delete">
	<label>Update Synopsis</label><input type="radio" name="synopsis" value="update">
	<label></label><input type="submit" name="addsynopsis">
	</form>
	</div>';
}

?>