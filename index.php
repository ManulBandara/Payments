<?php include('header.php');?>
<?php require 'config.php'; ?>

 <!DOCTYPE html>
<html lang="en" dir="ltr">
	<head> 
		<meta charset="utf-8">
		<title>Payments</title>
	</head>
	<body>
		<form class="" action="" method="post" enctype="multipart/form-data">
			<input type="file" name="excel" required value="">
			<button type="submit" name="import" width>Import</button>
		</form>
		<hr>
		<table border="1">
			<tr>
				
				<td><b><h5>#</h5></b></td>
				<td><h5>Row Labels</h5></td>
				<td><h5>Bill Payments</h5></td>
				<td><h5>CRM</h5></td>
				<td><h5>MISC</h5></td>
				<td><h5>Mobitel</h5></td>
				<td><h5>Prepaid</h5></td> 
			    <td><h5>Grand Total</h5></td>
				
				
				
			
				
				
			</tr>
			<?php
			$i = 1;
			$rows = mysqli_query($conn, "SELECT * FROM payments");
			foreach($rows as $row) :
			?>
			<tr>

				<td> <?php echo $i++; ?> </td>
                <td> <?php echo $row['row_labels']; ?> </td>
                <td> <?php echo $row['bill_payments']; ?> </td>
                <td> <?php echo $row['crm']; ?> </td>
                <td> <?php echo $row['misc']; ?> </td>
                <td> <?php echo $row['mobitel']; ?> </td>
                <td> <?php echo $row['prepaid']; ?> </td>
                <td> <?php echo $row['grand_total']; ?> </td>
				
				
				
				<td><a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a></td>

			</tr>
			<?php endforeach; ?>
		</table>

		<?php

if(isset($_GET['delete_msg'])){
    echo "<h6>".$_GET['delete_msg']."</h6>";
}

?>
		<?php
		if(isset($_POST["import"])){
			$fileName = $_FILES["excel"]["name"];
			$fileExtension = explode('.', $fileName);
            $fileExtension = strtolower(end($fileExtension));
			$newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

			$targetDirectory = "uploads/" . $newFileName;
			move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

			error_reporting(0);
			ini_set('display_errors', 0);

			require 'excelReader/excel_reader2.php';
			require 'excelReader/SpreadsheetReader.php';

			$reader = new SpreadsheetReader($targetDirectory);
			foreach($reader as $key => $row){
				    $row_labels= $row[0];
                    $bill_payments= $row[1];
                    $crm= $row[2];
                    $misc= $row[3];
                    $mobitel= $row[4];
                    $prepaid= $row[5];
                    $grand_total= $row[6];
				
				
				
				mysqli_query($conn, "INSERT INTO payments VALUES('', '$row_labels', '$bill_payments', '$crm', '$misc', '$mobitel', '$prepaid', '$grand_total')");
			}

			echo
			"
			<script>
			alert('Succesfully Imported');
			document.location.href = '';
			</script>
			";
		}
		?>
	</body>
</html>

<?php include('footer.php');?>