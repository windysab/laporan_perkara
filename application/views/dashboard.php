<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Dashboard</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Dashboard</li>

					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Small boxes (Stat box) -->
			<h4>Perkara</h4>
			<div class="row">
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<style>
						.rounded-box {
							border-radius: 50%;
							padding: 20px;
							text-align: center;
							height: 200px;
							width: 200px;
							display: flex;
							align-items: center;
							justify-content: center;
							flex-direction: column;
						}
					</style>
					

					<div class="col-lg-3 col-6">
						<!-- small box -->
						
						<div class="small-box bg-info rounded-box">
							<div class="inner">
								<?php
								require 'connectdb_dashboard.php';
								$currentYear = date('Y');
								$query = "select * from perkara where year(tanggal_pendaftaran)= '$currentYear'";
								$query_run = mysqli_query($connection, $query);
								$row = mysqli_num_rows($query_run);
								echo '<h3>' . $row . '</h3>Perkara';
								?>
								<p>Diterima</p>
							</div>
						</div>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-success rounded-box">
						<div class="inner">
							<?php
							//require 'connectdb_dashboard.php';
							$currentYear = date('Y');
							$query = "select * from perkara_putusan where year(tanggal_putusan)= '$currentYear'";

							$query_run = mysqli_query($connection, $query);
							//return $query->result();
							$row = mysqli_num_rows($query_run);
							echo '<h3>' . $row . '</h3>Perkara';
							?>
							<p>Putus</p>
						</div>

					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-warning rounded-box">
						<div class="inner">
							<?php
							//require 'connectdb_dashboard.php';
							$currentYear = date('Y');
							$query = "select * from perkara_putusan where year(tanggal_minutasi)= '$currentYear'";
							$query_run = mysqli_query($connection, $query);
							//return $query->result();
							$row = mysqli_num_rows($query_run);
							echo '<h3>' . $row . '</h3>Perkara';
							?>
							<p>Minutasi</p>
						</div>

					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-danger rounded-box">
						<div class="inner">
							<?php

							$currentYear = date('Y');
							$query = "select * from perkara
							      left join perkara_putusan on perkara.perkara_id = perkara_putusan.perkara_id
							      where tanggal_putusan is null and year(tanggal_pendaftaran)='$currentYear' ";


							$query_run = mysqli_query($connection, $query);
							//return $query->result();
							$row = mysqli_num_rows($query_run);
							echo '<h3>' . $row . '</h3>Perkara';
							?>
							<p>Sisa</p>
						</div>

					</div>
				</div>
				<!-- ./col -->

				<!-- /.row -->
				<!-- Main row -->

				<!-- /.row (main row) -->
			</div><!-- /.container-fluid -->

			<?php
			require 'connectdb_dashboard.php';
			$currentYear = date('Y');
			$currentMonth = date('m');
			

			// Fetch data from database
			$queries = [
				
				"select * from perkara where month(tanggal_pendaftaran)= '$currentMonth' and year(tanggal_pendaftaran)= '$currentYear'",
				"select * from perkara_putusan where month(tanggal_putusan)= '$currentMonth' and year(tanggal_putusan)= '$currentYear'",
				"select * from perkara_putusan where month(tanggal_minutasi)= '$currentMonth' and year(tanggal_minutasi)= '$currentYear'",
				"select * from perkara
		left join perkara_putusan on perkara.perkara_id = perkara_putusan.perkara_id
		where tanggal_putusan is null and month(tanggal_pendaftaran)= '$currentMonth' and year(tanggal_pendaftaran)= '$currentYear'",

				"select * from perkara where month(tanggal_pendaftaran)= '$currentMonth' and year(tanggal_pendaftaran)= '$currentYear'"
			];

			$data = [];
			foreach ($queries as $query) {
				$query_run = mysqli_query($connection, $query);
				$row = mysqli_num_rows($query_run);
				$data[] = $row;
			}
			?>

			<!-- Include Chart.js -->
			<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

			<!-- Canvas element where the chart will be drawn -->
			<!-- Canvas element where the chart will be drawn -->
			<!-- <canvas id="myChart" style="width: 400px; height: 200px;"></canvas> -->
			<!-- Canvas element where the chart will be drawn -->
			<canvas id="myChart" width="200" height="100"></canvas>

			<script>
				// Initialize a new Chart.js object
				var ctx = document.getElementById('myChart').getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'bar', // Change this to the type of chart you want
					data: {
						labels: ['Diterima', 'Putus', 'Minutasi', 'Sisa'],
						datasets: [{
							label: 'Perkara Bulan Ini',
							data: <?php echo json_encode($data); ?>,
							backgroundColor: [
								'rgba(54, 162, 235, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(255, 99, 132, 0.2)',
								'rgba(153, 102, 255, 0.2)'
							],
							borderColor: [
								'rgba(54, 162, 235, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(255, 99, 132, 1)',
								'rgba(153, 102, 255, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true
							}
						}
					}
				});
			</script>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

</body>

</html>
