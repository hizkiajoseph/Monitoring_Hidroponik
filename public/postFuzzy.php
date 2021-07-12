<?php
if (isset($_POST["phair"])) {
        hasilfuzzifikasi($_POST["suhu"], $_POST["kelembapan"], $_POST["phair"]);

        inferensi($_POST["suhu"], $_POST["kelembapan"], $_POST["phair"]);
}


function nilaigrafikphair($phair)
{
    $a = 0;
    if (phairasam($phair) != 0) {
        // echo "Asam (" . phairasam($phair) . ")";
        // echo "<br>";
        $a = "Acid";
    }
    if (phairnetral($phair) != 0) {
        // echo "Netral";
        // echo "<br>";
        $a = "Neutral";    
           
    }
    if (phairbasah($phair) != 0) {
        // echo "Basah (" . phairbasah($phair) . ")";
        // echo "<br>";
        $a = "Alkaline";
    }
    $nilaigraphair = $a;
    return $nilaigraphair;

}
function nilaigrafiksuhu($suhu)
{
    $b = 0;
    if (suhudingin($suhu) != 0) {
        // echo "Dingin (" . suhudingin($suhu) . ")";
        // echo "<br>";
        $b = "Cold";
    }
    if (suhunormal($suhu) != 0) {
        // echo "Normal (" . suhunormal($suhu) . ")";
        // echo "<br>";
        $b = "Normal";
    }
    if (suhupanas($suhu) != 0) {
        // echo "Panas (" . suhupanas($suhu) . ")";
        // echo "<br>";\
        $b = "Hot";
    }
    $nilaigrapsuhu = $b;
    return $nilaigrapsuhu;
}
function nilaigrafikkelembapan($kelembapan)
{
    $c = 0;
    if (lembab($kelembapan) != 0) {
        // echo "Lembab (" . lembab($kelembapan) . ")";
        // echo "<br>";
        $c = "Humid";
    }
    if (sangatlembab($kelembapan) != 0) {
        // echo "Sangat Lembab (" . sangatlembab($kelembapan) . ")";
        // echo "<br>";
        $c = "Very Humid";
    }
    $nilaigrapkelembapan = $c;
    return $nilaigrapkelembapan;
}


function hasilfuzzifikasi($suhu, $kelembapan, $phair)
{
    // echo "<h4><b>Hasil Fuzzifikasi: </b></h4>";
    // echo "<p><b>Nilai Fuzzy pH Air: </b></p>";
    nilaigrafikphair($phair);    
    // echo "<p><b>Nilai Fuzzy Suhu: </b></p>";
    nilaigrafiksuhu($suhu);
    // echo "<p><b>Nilai Fuzzy Kelembapan: </b></p>";
    nilaigrafikkelembapan($kelembapan);
    
    
}
function inferensi($suhu, $kelembapan, $phair)
{
    // echo "<h4><b>Rules yang digunakan: </b></h4>";
    $hasilphair = nilaigrafikphair($phair);
    $hasilnilaiphairasam = phairasam($phair);
    $hasilnilaiphairnetral = phairnetral($phair);
    $hasilnilaiphairbasa = phairbasah($phair);

    $hasilsuhu = nilaigrafiksuhu($suhu);
    $hasilnilaisuhudingin = suhudingin($suhu);
    $hasilnilaisuhunormal = suhunormal($suhu);
    $hasilnilaisuhupanas = suhupanas($suhu);

    $hasilkelembapan = nilaigrafikkelembapan($kelembapan);
    $hasilnilaikelembapan = lembab($kelembapan);
    $hasilnilaisangatlembap = sangatlembab($kelembapan);




    //echo $hasilphair;

    $x = 0; 
    $no = 1;
    $kondisi = [];
    $nilaiphair = [phairasam($phair), phairnetral($phair), phairbasah($phair)];
    $nilaisuhu = [suhudingin($suhu), suhunormal($suhu), suhupanas($suhu)];
    $nilaikelembapan = [lembab($kelembapan), sangatlembab($kelembapan)];
    $hasil = '';

    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            for ($k = 0; $k < 2; $k++) {
                if (($nilaiphair[$i] > 0) && ($nilaikelembapan[$k] > 0) && ($nilaisuhu[$j] > 0)) {
                    $minimal[$x] = min($nilaisuhu[$j], $nilaikelembapan[$k], $nilaiphair[$i]);
                    if ($k == 1) {
                        $kondisi[$x] = "Beyond the Limits";
                    } else if (($i == 1) && ($j == 1) && ($k == 0) ) {
                        $kondisi[$x] = "Normal Condition";
                    } else {
                        $kondisi[$x] = "Beyond the Limits";
                    }
                    // echo "<p>[R" . $no ."]. IF pH Air = " . $nilaiphair[$i] . ". AND Suhu = " . $nilaisuhu[$j] . " AND Kelembapan = " . $nilaikelembapan[$k] .  " THAN Peringatan = " . $kondisi[$x] . "(" . $minimal[$x] . ")</p>";
                    $hasil = $kondisi[$x];
                    $x++;
                }
                $no++;
            }
        }
    }

    //Nilai Fuzzy Output
    $nilai_banyak = 0;
    $nilai_sedikit = 0;
    for ($l = 0; $l < $x; $l++) {
        if ($kondisi[$l]  == "Beyond the Limits") {
            $nilai_banyak = max($minimal[$l], $nilai_banyak);
        } else {
            $nilai_sedikit = max($minimal[$l], $nilai_sedikit);
        }
    }
    // echo "<h4><b>Nilai Fuzzy Output: </b></h4>";
    // echo "<p>Di Luar Ambang Batas(" . $nilai_banyak . ")</p>";
    // echo "<p>Kondiris Normal( " . $nilai_sedikit . ")</p>";
    //Defuzzifikasi
    // echo '<h4><b>Defuzzifikasi</b></h4>';
    // echo '<p>Menggunakan metode Centroid Method</p>';

    $a1 = nilaiX($nilai_sedikit, 2, 4);
    $a2 = nilaiX($nilai_banyak, 2, 4);

    $M1 = simpleIntegral($nilai_sedikit, 1, 0, $a1);
    $M2 = midIntegral(2, 4, 1, $a1, $a2);
    $M3 = simpleIntegral($nilai_banyak, 1, $a2, 4);

    $A1 = simpleIntegral($nilai_sedikit, 0, 0, $a1);
    $A2 = midIntegral(2, 4, 0, $a1, $a2);
    $A3 = simpleIntegral($nilai_banyak, 0, $a2, 4);


  
    $coa = ($M1 + $M2 + $M3) / ($A1 + $A2 + $A3);

    echo json_encode(array(
    // 'a'=> $a;
    // 'b'=> $b;
    // 'c'=> $c;
    'hasilnilaiphairasam' => $hasilnilaiphairasam, 
    'hasilnilaiphairnetral' => $hasilnilaiphairnetral, 
    'hasilnilaiphairbasa' => $hasilnilaiphairbasa, 

    'hasilnilaisuhudingin' => $hasilnilaisuhudingin, 
    'hasilnilaisuhunormal' => $hasilnilaisuhunormal, 
    'hasilnilaisuhupanas' => $hasilnilaisuhupanas, 

    'hasilnilaikelembapan' => $hasilnilaikelembapan, 
    'hasilnilaisangatlembap' => $hasilnilaisangatlembap, 

    'nilai_banyak' => $nilai_banyak, 
    'nilai_sedikit' => $nilai_sedikit, 
  
    'hasil' => $hasil,
    'coa' => $coa,
    'hasilphair' => $hasilphair, 
    'hasilsuhu' => $hasilsuhu, 
    'hasilkelembapan' => $hasilkelembapan,

    'a1' => $a1,
    'a2' => $a2,


    // echo "<p>[R" . $no ."]. IF pH Air = " . $nilaiphair[$i] . ". AND Suhu = " . $nilaisuhu[$j] . " AND Kelembapan = " . $nilaikelembapan[$k] .  " THAN Peringatan = " . $kondisi[$x] . "(" . $minimal[$x] . ")</p>";



    //'hasilphair1' => $phair,
    //'hasilsuhu1' => $suhu,
    //'hasilkelembapan1' => $kelembapan

    ));

    // echo '<img src="https://latex.codecogs.com/svg.latex?z*&space;=&space;\frac{(' . $M1 . ')&plus;(' . $M2 . ')&plus;(' . $M3 . ')}{(' . $A1 . ')&plus;(' . $A2 . ')&plus;(' . $A3 . ')}"/>';

    
    //, 'hasilphair' => $hasilphair
    //$nilaiy = ((10 * $nilai_sedikit) + (40 * $nilai_banyak) + 0.5) / ((5 * $nilai_sedikit) + (5 * $nilai_banyak) + 0.5);
}


function nilaiX($sama, $min, $max)
{
    $x1 = 0;
    $x1 = ($sama * ($max-$min)) + $min;
    return $x1;
}

function simpleIntegral($value, $pow, $min, $max)
{
    $result = 0;

    if ($min == 0) {
        $result = pow($max, $pow + 1) * ($value / ($pow + 1));
    } else {
        $result = pow($max, $pow + 1) * ($value / ($pow + 1)) - pow($min, $pow + 1) * ($value / ($pow + 1));
    }
    return $result;
}

function midIntegral($value, $pembagi, $pow, $min, $max)
{
    $result = 0;
    if ($pow == 1) {
        $pow1 = 2;
        $pow2 = 1;
    } else {
        $pow1 = 1;
        $pow2 = 0;
    }

    $h1 = (1 / $pembagi) / ($pow1 + 1);
    $h2 = ($value / $pembagi) / ($pow2 + 1);
    $result = ($h1 * pow($max, $pow1 + 1) - $h2 * pow($max, $pow2 + 1)) - ($h1 * pow($min, $pow1 + 1) - $h2 * pow($min, $pow2 + 1));
    return $result*2;
}


function phairasam($phair)
{
    $nilaiphairasam = 0;
    //suhu optimal
    if ($phair >= 0 && $phair <= 5.8) {
        if ($phair == 2.9) {
            $nilaiphairasam = 1;
        } else {
            if ($phair >= 0 && $phair < 2.9) {
                $nilaiphairasam = ($phair - 0) / 2.9;
            } else {
                if ($phair > 2.9 && $phair <= 5.8) {
                    $nilaiphairasam = (5.8 - $phair) / 2.9;
                } else {
                    $nilaiphairasam = 0;
                }
            }
        }
    }
    return $nilaiphairasam;
}
function phairnetral($phair)
{
    $nilaiphairnetral = 0;
    //suhu optimal
    if ($phair >= 5.5 && $phair <= 6.5) {
        if ($phair == 6) {
            $nilaiphairnetral = 1;
        } else {
            if ($phair >= 5.5 && $phair < 6) {
                $nilaiphairnetral = ($phair - 5.5) / 0.5;
            } else {
                if ($phair > 6 && $phair <= 6.5) {
                    $nilaiphairnetral = (5.5 - $phair) / 0.5;
                } else {
                    $nilaiphairnetral = 0;
                }
            }
        }
    }
    return $nilaiphairnetral;
}
function phairbasah($phair)
{
    $nilaiphairbasah = 0;
    //suhu optimal
    if ($phair >= 6.1 && $phair <= 14) {
        if ($phair == 10.1) {
            $nilaiphairbasah = 1;
        } else {
            if ($phair >= 6.1 && $phair < 10.1) {
                $nilaiphairbasah = ($phair - 6.1) / 4;
            } else {
                if ($phair > 10.1 && $phair <= 14) {
                    $nilaiphairbasah = (14 - $phair) / 3.9;
                } else {
                    $nilaiphairbasah = 0;
                }
            }
        }
    }
    return $nilaiphairbasah;
}

function suhudingin($suhu)
{
    $nilaisuhudingin = 0;
    //tinggi air kering
    if ($suhu <= 0) {
        $nilaisuhudingin = 1;
    } else {
        if ($suhu <= 22) {
            $nilaisuhudingin = (22 - $suhu) / 22;
        } else {
            $nilaisuhudingin = 0;
        }
    }
    return $nilaisuhudingin;
}
function suhunormal($suhu)
{
    $nilaisuhunormal = 0;
    //suhu optimal
    if ($suhu >= 20 && $suhu <= 30) {
        if ($suhu == 25) {
            $nilaisuhunormal = 1;
        } else {
            if ($suhu >= 20 && $suhu < 25) {
                $nilaisuhunormal = ($suhu - 20) / 5;
            } else {
                if ($suhu > 25 && $suhu <= 30) {
                    $nilaisuhunormal = (30 - $suhu) / 5;
                } else {
                    $nilaisuhunormal = 0;
                }
            }
        }
    }
    return $nilaisuhunormal;
}
function suhupanas($suhu)
{
    $nilaisuhupanas = 0;
    //tinggi air banjir
    if ($suhu >= 50) {
        $nilaisuhupanas = 1;
    } else {
        if ($suhu >= 28 && $suhu <= 50) {
            $nilaisuhupanas = ($suhu - 28) / 22;
        } else {
            $nilaisuhupanas = 0;
        }
    }
    return $nilaisuhupanas;
}


function lembab($kelembapan)
{
    $kelembapanlembab = 0;
    //suhu optimal
    if ($kelembapan >= 0 && $kelembapan <= 85) {
        if ($kelembapan == 43) {
            $kelembapanlembab = 1;
        } else {
            if ($kelembapan >= 0 && $kelembapan < 43) {
                $kelembapanlembab = ($kelembapan - 0) / 43;
            } else {
                if ($kelembapan > 43 && $kelembapan <= 85) {
                    $kelembapanlembab = (85 - $kelembapan) / 42;
                } else {
                    $kelembapanlembab = 0;
                }
            }
        }
    }
    return $kelembapanlembab;
}

function sangatlembab($kelembapan)
{
    $kelembapansangatlembab = 0;
    //suhu optimal
    if ($kelembapan >= 80 && $kelembapan <= 100) {
        if ($kelembapan == 90) {
            $kelembapansangatlembab = 1;
        } else {
            if ($kelembapan >= 80 && $kelembapan < 90) {
                $kelembapansangatlembab = ($kelembapan - 80) / 10;
            } else {
                if ($kelembapan > 90 && $kelembapan <= 100) {
                    $kelembapansangatlembab = (100 - $kelembapan) / 10;
                } else {
                    $kelembapansangatlembab = 0;
                }
            }
        }
    }
    return $kelembapansangatlembab;
}