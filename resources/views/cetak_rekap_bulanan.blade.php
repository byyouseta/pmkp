<!DOCTYPE html>
<html lang="en">

<head>
    <title>Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="adminlte/plugins/bootstrap413/dist/css/bootstrap.min.css"> --}}
    <style>
        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            color: black;
            text-align: right;
            line-height: 12px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            color: grey;
            text-align: right;
            font-size: 11px;
            line-height: 35px;
        }

    </style>
</head>

<body>
    <style type="text/css">
        table tr td,

        table tr th {

            font-size: 9pt;

        }

    </style>

    @php
        $hariini = $data3;
    @endphp

    <table class="table table-borderless mb-3">
        <thead>
            <tr class="text-center">
                <th>
                    <h6>FORM SASARAN KINERJA UNIT</h6>
                    <h6 class="text-uppercase">{{ $data->nama_unit }} RSUP SURAKARTA</h6>
                    <h6>TAHUN {{ $hariini->year }}</h6>
                </th>
            </tr>
        </thead>
    </table>
    <div>
        <label style="font-size: 9pt">BULAN :</label>
        <label class="text-uppercase" style="font-size: 9pt">{{ $hariini->locale('id')->monthName }}</label>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr class="text-uppercase">
                <th class="text-center align-middle" style="width: 20px">No</th>
                <th class="text-center align-middle" style="width: 150px">Indikator Kinerja
                </th>
                <th class="text-center align-middle" style="width: 50px">Satuan</th>
                <th class="text-center align-middle">Target (/Bulan)</th>
                <th class="text-center align-middle">Bobot (%)</th>
                <th class="text-center align-middle" style="width: 150px">Range</th>
                <th class="text-center align-middle">Capaian</th>
                <th class="text-center align-middle">Haper</th>
                <th class="text-center align-middle">Haper x Bobot</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalpersen = 0;
            @endphp
            @if (!empty($data2))
                @foreach ($data2 as $index => $list)
                    <tr>
                        <td class="text-center">{{ ++$index }}</td>
                        <td>{{ $list->nama }}</td>
                        <td class="text-center">{{ $list->satuan->keterangan }}</td>
                        <td class="text-center">{{ $list->target }}</td>
                        <td class="text-center">{{ $list->bobot }}%</td>
                        <td class="text-center">
                            @foreach ($list->range as $rangelist)
                                ({{ $rangelist->awal }}-{{ $rangelist->akhir }}{{ $list->satuan->nama }})
                                {{ $rangelist->nilai }} <br>
                            @endforeach
                        </td>
                        @php
                            $tgl = $data3;
                        @endphp
                        @if (!empty(\App\Nilai::list($list->id, $tgl)))
                            <td class="text-center">

                                @if (!empty(\App\Nilai::list($list->id, $tgl)->nilai))
                                    {{ \App\Nilai::list($list->id, $tgl)->nilai }}{{ $list->satuan->nama }}
                                @else
                                    @php
                                        $nilai = (\App\Nilai::list($list->id, $tgl)->nilai_n / \App\Nilai::list($list->id, $tgl)->nilai_d) * 100;
                                    @endphp
                                    {{ number_format($nilai, 2) }}{{ $list->satuan->nama }}
                                @endif
                            </td>
                        @else
                            <td class="text-center"> -
                            </td>
                        @endif
                        @if (!empty(\App\Nilai::list($list->id, $tgl)))
                            @if ($list->range->count() > 0)
                                <td class="text-center">
                                    {{ \App\Nilai::haper($list->id, $tgl)->nilai }}
                                </td>
                            @else
                                <td class="text-center">
                                    Range tidak ada
                                </td>
                            @endif
                        @else
                            <td class="text-center"> -
                            </td>
                        @endif
                        @if ((!empty(\App\Nilai::list($list->id,
                        $tgl)))&&(!empty(\App\Nilai::haper($list->id, $tgl))))
                        @php
                            $persentase = (\App\Nilai::haper($list->id, $tgl)->nilai * $list->bobot) / 100;
                            $totalpersen = $totalpersen + $persentase;
                        @endphp
                        <td class="text-center">
                            {{ $persentase }}
                        </td>
                    @else
                        <td class="text-center"> -
                        </td>
                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="16" class="text-center">Data tidak ditemukan</td>
            </tr>
            @endif

        </tbody>
        @if ($totalpersen > 0)
            <tfoot>
                <tr>
                    <td colspan="8" class="font-weight-bold text-right">Total
                    </td>
                    <td class="font-weight-bold text-center">{{ $totalpersen }}</td>
                </tr>
                <tr>
                    <td colspan="8" class="font-weight-bold text-right">IKU
                    </td>
                    <td class="font-weight-bold text-center">{{ $totalpersen / 100 }}</td>
                </tr>
            </tfoot>
        @endif
    </table>
</body>
