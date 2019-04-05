<!DOCTYPE html>
<html>
<head>
	<title>Book Library</title>
</head>
<body>
	<h1 align="center">Library System</h1>
	<?php
		if (isset($_GET['edit'])) {
			$id = $_GET['id'];

			$book= new Library;
			$myrow = $book->select($id);

			foreach ($myrow as $row) {
				$id = $row['id'];
				$author = $row['author'];
				$book_title = $row['book_title'];
				$publisher = $row['publisher'];
				$category = $row['category'];
			}
				?>
					<form action="index.php" method="post">
						<input type="hidden" name="id" value="<?php echo $id; ?>">

						<label>Author</label>
						<input type="text" name="author" value="<?php echo $author; ?>" required><br><br>

						<label>Book Title</label>
						<input type="text" name="book_title" value="<?php echo $book_title; ?>" required><br><br>

						<label>Publisher</label>
						<input type="text" name="publisher" value="<?php echo $publisher; ?>" required><br><br>

						<label>Category</label>
						<select name="category" required>
							<option value="<?php echo $category; ?>"><?php echo $category; ?></option>
							<option value="Educational">Educational</option>
							<option value="Entertainment">Entertainment</option>
							<option value="Cooking">Cooking</option>
							<option value="Sports">Sports</option>
						</select><br><br>

						<input type="submit" name="update" value="Update"><vr>
						<a href="index.php">Cancel</a>
					</form>
				<?php
		}

		else{
	?>

			<form action="index.php" method="post">
				<label>Author</label>
				<input type="text" name="author" required><br><br>

				<label>Book Title</label>
				<input type="text" name="book_title" required><br><br>

				<label>Publisher</label>
				<input type="text" name="publisher" required><br><br>

				<label>Category</label>
				<select name="category" required>
					<option value=""></option>
					<option value="Educational">Educational</option>
					<option value="Entertainment">Entertainment</option>
					<option value="Cooking">Cooking</option>
					<option value="Sports">Sports</option>
				</select><br><br>

				<input type="submit" name="submit" value="Insert">
			</form>
		<?php
			}
		?>

	<table class="table table-hover" align="center">
		<tr>
			<th>ID</th>
			<th>Author</th>
			<th>Book Title</th>
			<th>Publisher</th>
			<th>Category</th>
			<th>Actions</th>
		</tr>
		<?php
			$book = new Library;
			$myrow = $book->fetch_record();

			foreach ($myrow as $row) {
				?>
					<tr>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $row['author']; ?></td>
						<td><?php echo $row['book_title']; ?></td>
						<td><?php echo $row['publisher']; ?></td>
						<td><?php echo $row['category']; ?></td>
						<td>
							<a href="index.php?edit=1&id=<?php echo $row['id']?>">Update</a>&nbsp
							<a href="index.php?delete=1&id=<?php echo $row['id']?>">Delete</a>
						</td>
					</tr>
				<?php
			}
		?>
	</table>
</body>
</html>

<?php
	class Database{
		private $servername;
		private $username;
		private $password;
		private $dbname;

		protected function connect(){
			$this->servername='localhost';
			$this->username='root';
			$this->password='';
			$this->dbname='oopcrud';

			$con = new mysqli($this->servername,$this->username,$this->password,$this->dbname);

			return $con;
		}
	}

	class Library extends Database{

		public function insert($author,$book_title,$publisher,$category){
			$this->author = $author;
			$this->book_title = $book_title;
			$this->publisher = $publisher;
			$this->category = $category;

			$sql="INSERT INTO library(author,book_title,publisher,category) VALUES(
					'$this->author',
					'$this->book_title',
					'$this->publisher',
					'$this->category')";

			$result=$this->connect()->query($sql);
		}

		public function select($id){
			$this->id = $id;

			$sql = "SELECT * FROM library WHERE id='$this->id'";
			$array = array();
			$query = $this->connect()->query($sql);
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row;
			}
			return $array;
		}

		public function update($id,$author,$book_title,$publisher,$category){
			$this->id = $id;
			$this->author = $author;
			$this->book_title = $book_title;
			$this->publisher = $publisher;
			$this->category = $category;

			$sql= "UPDATE library
					SET author='$this->author',
						book_title='$this->book_title',
						publisher='$this->publisher',
						category='$this->category'
					WHERE id='$this->id = $id'";

			$result=$this->connect()->query($sql);
		}

		public function delete($id){
			$this->id = $id;

			$sql="DELETE FROM library WHERE id='$this->id'";

			$result=$this->connect()->query($sql);
		}


		public function fetch_record(){
			$sql = "SELECT * FROM library";
			$array = array();
			$query = $this->connect()->query($sql);
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row;
			}
			return $array;
		}
	}

	if (isset($_POST['submit'])) {
		$author = $_POST['author'];
		$book_title = $_POST['book_title'];
		$publisher = $_POST['publisher'];
		$category = $_POST['category'];

		$book->insert($author,$book_title,$publisher,$category);
		header("location:index.php");
	}

	if (isset($_POST['update'])) {
		$id = $_POST['id'];
		$author = $_POST['author'];
		$book_title = $_POST['book_title'];
		$publisher = $_POST['publisher'];
		$category = $_POST['category'];

		$book->update($id,$author,$book_title,$publisher,$category);
		header("location:index.php");
	}


	if (isset($_GET['delete'])) {
		$id = $_GET['id'];

		$book->delete($id);
		header("location:index.php");
	}
?>