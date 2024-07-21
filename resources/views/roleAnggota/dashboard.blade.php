<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="wrapper">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <div class="main-panel">
            <!-- Navbar -->
            <x-main-header></x-main-header>

            <!-- Content -->
            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Dashboard</h3>
                            <h6 class="op-7 mb-2">Koperasi SMKN 2 Bandar Lampung</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                                <i class="fas fa-user-check"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Ketua Pengurus</p>
                                                <h4 class="card-title">Teguh Sugiarto, S.Kom.</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Total Anggota</p>
                                                <h4 class="card-title">{{ $user }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                                <i class="fas fa-donate"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Total Simpanan</p>
                                                <h4 class="card-title">-</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Grafik Keuangan Anggota Koperasi</div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="multipleLineChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-primary card-round" style="height: 400px;">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">
                                            <h1>Info Cuaca Hari Ini</h1>
                                        </div>
                                    </div>
                                    <div class="card-category">
                                        <h2 id="currentDate"></h2>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        <h4 id="temperature"></h4>
                                    </div>
                                    <div class="pull-in mb-2">
                                        <img id="weatherIcon" alt="Weather Icon" style="height: 100px; width:100px;" />
                                    </div>
                                    <div>
                                        <h4 id="weatherDescription"></h4>
                                    </div>
                                    <div>
                                        <h4 id="currentTime"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Our Location</div>
                            <p>Map of the distribution of users around the world</p>
                        </div>
                        <div class="card-body">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1364.4547130584026!2d105.24535378298933!3d-5.364128239866796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40c535b64632bb%3A0x7774722ca7fc4461!2sSMK%20Negeri%202%20Bandar%20Lampung!5e0!3m2!1sid!2sid!4v1720033567049!5m2!1sid!2sid"
                                width="600" height="450" style="border: 0; width: 100%" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <x-footer></x-footer>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>
    <script>
        function translateWeatherDescription(description) {
            const translations = {
                'clear sky': 'langit cerah',
                'few clouds': 'sedikit awan',
                'scattered clouds': 'awan tersebar',
                'broken clouds': 'awan terpecah',
                'shower rain': 'hujan ringan',
                'rain': 'hujan',
                'thunderstorm': 'badai petir',
                'snow': 'salju',
                'mist': 'kabut',
                'patchy rain nearby': 'hujan merata disekitar',
            };

            // Capitalize first letter and translate
            const lowerCaseDescription = description.toLowerCase();
            return translations[lowerCaseDescription] || description;
        }

        function fetchWeatherData() {
            // Use a weather API of your choice. Example uses OpenWeatherMap.
            const apiKey = '6888cc216e194454a3f34604241807';
            const city = 'Bandar Lampung';
            const apiUrl = `http://api.weatherapi.com/v1/current.json?key=${apiKey}&q=${city}`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    const temperatureElement = document.getElementById('temperature');
                    const weatherDescriptionElement = document.getElementById('weatherDescription');
                    const weatherIconElement = document.getElementById('weatherIcon');

                    const temperature = data.current.temp_c;
                    const weatherDescription = translateWeatherDescription(data.current.condition.text.toLowerCase());
                    const weatherIcon = data.current.condition.icon;

                    temperatureElement.innerHTML = `${temperature}°C`;
                    weatherDescriptionElement.innerHTML = weatherDescription;

                    // Tampilkan ikon cuaca
                    weatherIconElement.src = `https:${weatherIcon}`;
                    weatherIconElement.alt = weatherDescription; // Teks alternatif untuk aksesibilitas
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });
        }

        function updateDateTime() {
            const now = new Date();

            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const currentDate = `${dayName}, ${day} ${month} ${year}`;
            const currentTime = `${hours}:${minutes}:${seconds}`;

            document.getElementById('currentDate').textContent = currentDate;
            document.getElementById('currentTime').textContent = currentTime;
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Fetch weather data from an API
            fetchWeatherData();

            // Update the date and time every second
            setInterval(updateDateTime, 1000);

            fetch('/anggota/chart-data')
                .then(response => response.json())
                .then(data => {
                    var ctx = document.getElementById("multipleLineChart").getContext("2d");

                    var myMultipleLineChart = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep",
                                "Oct", "Nov", "Dec"
                            ],
                            datasets: [{
                                    label: "Total Pinjaman",
                                    borderColor: "#1d7af3",
                                    pointBorderColor: "#FFF",
                                    pointBackgroundColor: "#1d7af3",
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 4,
                                    pointHoverBorderWidth: 1,
                                    pointRadius: 4,
                                    backgroundColor: "transparent",
                                    fill: false,
                                    borderWidth: 2,
                                    data: data.pinjaman
                                },
                                {
                                    label: "Total Simpanan Pokok",
                                    borderColor: "#59d05d",
                                    pointBorderColor: "#FFF",
                                    pointBackgroundColor: "#59d05d",
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 4,
                                    pointHoverBorderWidth: 1,
                                    pointRadius: 4,
                                    backgroundColor: "transparent",
                                    fill: false,
                                    borderWidth: 2,
                                    data: data.simpanan
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                position: "top"
                            },
                            tooltips: {
                                bodySpacing: 4,
                                mode: "nearest",
                                intersect: 0,
                                position: "nearest",
                                xPadding: 10,
                                yPadding: 10,
                                caretPadding: 10
                            },
                            layout: {
                                padding: {
                                    left: 15,
                                    right: 15,
                                    top: 15,
                                    bottom: 15
                                }
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        maxTicksLimit: 5,
                                        padding: 20
                                    },
                                    gridLines: {
                                        drawTicks: false,
                                        display: false
                                    }
                                }],
                                xAxes: [{
                                    gridLines: {
                                        zeroLineColor: "transparent"
                                    },
                                    ticks: {
                                        padding: 20
                                    }
                                }]
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching chart data:', error);
                });
        });
    </script>
</x-layout>
