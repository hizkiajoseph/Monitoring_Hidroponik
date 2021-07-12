var firebaseConfig = {
  piKey: "AIzaSyBx6cjvQAWk3JWcF89C3VqDRhVb5GyLWIc",
  authDomain: "esp8622---dht-22.firebaseapp.com",
  databaseURL: "https://esp8622---dht-22-default-rtdb.firebaseio.com",
  projectId: "esp8622---dht-22",
  storageBucket: "esp8622---dht-22.appspot.com",
  messagingSenderId: "565932780853",
  appId: "1:565932780853:web:d87b7e730796eb766df07c",
  measurementId: "G-PC9NCHKWQX"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
database = firebase.database();
var ref = database.ref('Monitoring_Hidroponik');
ref.on('value', gotData, errData, );


var pH_Air = 0;
var Suhu = 0;
var Kelembapan = 0;


function gotData(data){
  //console.log(data.val());
  var values = data.val();
  var keys = Object.keys(values);
  //console.log(keys);
  
  for (var i = 0; i < keys.length; i++) {
    var k = keys[i];
    var pH_Air = values[k].pH_Air;
    var Suhu = values[k].Suhu;
    var Kelembapan = values[k].Kelembapan;

    var pH_Air_pembulatan = Math.round((pH_Air + Number.EPSILON) * 100) / 100;
    var Suhu_pembulatan = Math.round((Suhu + Number.EPSILON) * 10) / 10;
    
    if (i==keys.length-1) {


      var phair = document.getElementById('phair');
      phair.innerHTML = pH_Air_pembulatan;

      var temp = document.getElementById('temp');
      temp.innerHTML = Suhu_pembulatan+"°C";

      var hum = document.getElementById('hum');
      hum.innerHTML = Kelembapan+"%";

      sendData(pH_Air_pembulatan, Suhu_pembulatan, Kelembapan, k);

    }
     
  }
  
}

// console.log(tampilhasil);

function sendData(pH_Air_pembulatan, Suhu_pembulatan, Kelembapan, k){
  let fd = new FormData();
  fd.append("phair", pH_Air_pembulatan);
  fd.append("suhu", Suhu_pembulatan);
  fd.append("kelembapan", Kelembapan);

  var peringatan = document.getElementById("hasil");
  var peringatanphair = document.getElementById("hasilphair");
  var peringatansuhu = document.getElementById("hasilsuhu");
  var peringatankelembapan = document.getElementById("hasilkelembapan");



  axios.post("PostFuzzy.php",fd).then(function(response){
    console.log(response.data);

    document.getElementById('hasilnilaiphairasam').innerHTML = "Acid: "+response.data.hasilnilaiphairasam;
    document.getElementById('hasilnilaiphairnetral').innerHTML = "Netral: "+response.data.hasilnilaiphairnetral;
    document.getElementById('hasilnilaiphairbasa').innerHTML = "Alkaline: "+response.data.hasilnilaiphairbasa;

    document.getElementById('hasilnilaisuhudingin').innerHTML = "Cold: "+response.data.hasilnilaisuhudingin;
    document.getElementById('hasilnilaisuhunormal').innerHTML = "Normal: "+response.data.hasilnilaisuhunormal;
    document.getElementById('hasilnilaisuhupanas').innerHTML = "Hot: "+response.data.hasilnilaisuhupanas;

    document.getElementById('hasilnilaikelembapan').innerHTML = "Humid: "+response.data.hasilnilaikelembapan;
    document.getElementById('hasilnilaisangatlembap').innerHTML = "Very Humid: "+response.data.hasilnilaisangatlembap;

    document.getElementById('nilai_sedikit').innerHTML = "Normal Condition: "+response.data.nilai_sedikit;
    document.getElementById('nilai_banyak').innerHTML = "Beyond the Limits: "+response.data.nilai_banyak;

    document.getElementById('coa').innerHTML = "Value of warning is (z*): "+response.data.coa;

    document.getElementById('hasil').innerHTML = response.data.hasil;
    document.getElementById('hasilphair').innerHTML = response.data.hasilphair;
    document.getElementById('hasilsuhu').innerHTML = response.data.hasilsuhu;
    document.getElementById('hasilkelembapan').innerHTML = response.data.hasilkelembapan;
    // console.log(tampilhasil);
    // tampilhasil.innerHTML = response.data;

// ---------------------------------Warning-----------------------------------
    if (response.data.hasil=="Beyond the Limits") {
    peringatan.setAttribute("style","color: #EB5757");
    }else{
      peringatan.setAttribute("style","color: #6FCF97")
    }

    // HasilphAir
    if (response.data.hasilphair=="Acid") {
      peringatanphair.setAttribute("style","color: #F2C94C");
    }else if (response.data.hasilphair=="Neutral"){
      peringatanphair.setAttribute("style","color: #6FCF97");
    }
    else{
      peringatanphair.setAttribute("style","color: #EB5757")
    }

    // Hasilphsuhu
    if (response.data.hasilsuhu=="Cold") {
      peringatansuhu.setAttribute("style","color: #F2C94C");
    }else if (response.data.hasilsuhu=="Normal"){
      peringatansuhu.setAttribute("style","color: #6FCF97");
    }
    else{
      peringatansuhu.setAttribute("style","color: #EB5757")
    }

    // Hasilkelembapan
    if (response.data.hasilkelembapan=="Humid") {
      peringatankelembapan.setAttribute("style","color: #6FCF97");
    }else{
      peringatankelembapan.setAttribute("style","color: #EB5757")
    }

 

// ----------------------------------------Rules---------------------------------
 
//function aturan_fuzzy(){
    let text = "";
    var x = 0; 
    var no = 1;
    var minimal = 0;
    var ii = "";
    var jj = "";
    var kk = "";
    var kondisi = [];
    var nilaiphair = [response.data.hasilnilaiphairasam, response.data.hasilnilaiphairnetral, response.data.hasilnilaiphairbasa];
    var nilaisuhu = [response.data.hasilnilaisuhudingin, response.data.hasilnilaisuhunormal, response.data.hasilnilaisuhupanas];
    var nilaikelembapan = [response.data.hasilnilaikelembapan, response.data.hasilnilaisangatlembap];

    for (let i = 0; i < 3; i++) {
        if(i == 0){
            ii ="Acid";
        } else if (i == 1){
            ii ="Netral";
        } else {
            ii ="Alkaline";
        }
        for (let j = 0; j < 3; j++) {
            if (j == 0) {
                jj = "Cold";
            } else if (j == 1){
                jj ="Normal";
            } else {
                jj ="Hot";
            }
            for (let k = 0; k < 2; k++) {
                if (k == 0) {
                    kk = "Humid";
                } else {
                    kk ="Very Humid";
                }
                if ((nilaiphair[i] > 0) && (nilaikelembapan[k] > 0) && (nilaisuhu[j] > 0)) {
                    minimal = Math.min(nilaisuhu[j], nilaikelembapan[k], nilaiphair[i]);
                    if (k == 1) {
                        kondisi[x] = "Beyond the Limits";
                    } else if ((i == 1) && (j == 1) && (k == 0) ) {
                        kondisi[x] = "Normal Condition";
                    } else {
                        kondisi[x] = "Beyond the Limits";
                    }
                    // echo "<p>[R" . no ."]. IF pH Air = " . nilaiphair[i] . ". AND Suhu = " . nilaisuhu[j] . " AND Kelembapan = " . nilaikelembapan[k] .  " THAN Peringatan = " . kondisi[x] . "(" . minimal[x] . ")</p>";
                    text += "[R"+no+"] IF (Ph Air= "+ii+" ("+nilaiphair[i]+")) AND (Suhu= "+jj+" ("+nilaisuhu[j]+")) AND Kelembapan= ("+kk+" ("+nilaikelembapan[k]+")) THAN (Peringatan= "+kondisi[x]+" ("+minimal+")"+"<br>";
                    document.getElementById('aturan_fuzzy').innerHTML = text;
                    //document.getElementById('demo').innerHTML = "[R"+no+"] IF (Ph Air= "+ii+" ("+nilaiphair[i]+")) AND (Suhu= "+jj+" ("+nilaisuhu[j]+")) AND Kelembapan= ("+kk+" ("+nilaikelembapan[k]+")) THAN (Peringatan= "+kondisi[x]+" ("+minimal+")";
                    x++;
                }
                no++;
            }
        }
    }
//  }


// ------------------------------------Update Firebase--------------------------------------
    var hasil = {
      Hasil_Monitoring:{
      Kondisi_pH_Air : response.data.hasilphair,
      Kondisi_Suhu : response.data.hasilsuhu,
      Kondisi_Kelembapan : response.data.hasilkelembapan,
      Hasil_Peringatan : response.data.hasil,
      },
       Hasil_Fuzzy:{
      Step1_3 : text,
      Defuzzifikasi : response.data.coa,
      }
    }

    var ref2 = database.ref('Monitoring_Hidroponik/'+k);
    ref2.update(hasil);

  });


  
}

function errData(err){
  console.log('err');
  console.log(err);
}