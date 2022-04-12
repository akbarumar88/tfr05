@extends('layout')

@section('content')
    <h3 class="mb-4">Admin Dashboard</h3>

    <div id="myVizzu" style="width:800px; height:480px;"></div>

    <!-- Container untuk Diagram Lingkaran -->
    <div id="vizzuRadial" style="width:800px; height:480px;"></div>


    <!-- <script type="module">

    </script> -->
    <script type="module">
        import Vizzu from 'https://cdn.jsdelivr.net/npm/vizzu@0.4.3/dist/vizzu.min.js';
        (async () => {
            let barangUrutPengadaan = {!! json_encode($barang) !!}
            let kategoriUrutPengadaan = {!! json_encode($kategori) !!}
            let barangTerlaris = {!! json_encode($barangTerlaris)  !!}
            // console.log({barangUrutPengadaan,kategoriUrutPengadaan})

            // Data By Series
            let dataSample = {
                series: [{
                        name: 'Barang',
                        type: 'dimension',
                        values: barangTerlaris.map(el => el.nama)
                    },
                    {
                        name: 'Terjual',
                        type: 'measure',
                        values: barangTerlaris.map(el => el.terjual)
                    },
                ]
            };
            // console.log(dataSample)

            // Inisialisasi chart Vizzu
            let chart = new Vizzu('myVizzu', {
                data: dataSample
            })
            chart.animate({
                x: 'Barang',
                y: 'Terjual',
                geometry: 'line',
            });
            chart.animate({
                config: {
                    title: 'Data Penjualan Barang Terlaris',
                    channels: {
                        label: {
                            attach: ['Terjual']
                        }
                    },
                }
            })


            // Diagram Lingkaran
            let radialChart = new Vizzu('vizzuRadial');
            let radialChartData = {
                series: [{
                        name: 'Barang',
                        type: 'dimension',
                        values: barangUrutPengadaan.map(el => el.nama)
                    },
                    {
                        name: 'Stok',
                        type: 'measure',
                        values: barangUrutPengadaan.map(el => el.stock)
                    },
                ]
            }

            radialChart.animate({
                data: radialChartData,
                config: {
                    channels: {
                        x: {
                            set: ['Stok']
                        },
                        y: {
                            set: ['Barang'],
                            /* Setting the radius of the empty circle
                            in the centre. */
                            range: {
                                min: '-30%'
                            }
                        },
                        color: {
                            set: ['Barang']
                        },
                        label: {
                            set: ['Stok']
                        }
                    },
                    title: 'Data Pengadaan Stok Barang Terbanyak',
                    coordSystem: 'cartesian'
                },
                /* All axes and axis labels are unnecessary 
                on these types of charts, except for the labels 
                of the y-axis. */
                style: {
                    plot: {
                        yAxis: {
                            color: '#ffffff00',
                            label: {
                                paddingRight: 20
                            }
                        },
                        xAxis: {
                            title: {
                                color: '#ffffff00'
                            },
                            label: {
                                color: '#ffffff00'
                            },
                            interlacing: {
                                color: '#ffffff00'
                            }
                        }
                    }
                }
            });
            let i = 0
            setInterval(() => {
                let geometryChart1
                let coordSystemChart2
                if (i % 2 == 0) {
                    geometryChart1 = 'rectangle'
                    coordSystemChart2 = "polar"
                } else {
                    geometryChart1 = 'line'
                    coordSystemChart2 = "cartesian"
                }
                // Animasikan chart 1 (Batang)
                chart.animate({
                    geometry: geometryChart1,
                });
                // Animasikan chart 2 (Lingkaran / Kartesius)
                radialChart.animate({
                    config: {
                        coordSystem: coordSystemChart2
                    }
                })
                i++
            }, 5000)

            // chart.initializing.then(
            //     chart => chart.animate({
            //         dataBySeries
            //     })
            // )
        })()
    </script>
@endsection
