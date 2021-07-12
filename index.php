<?php include_once('_header.php'); ?>
    <div class="box">
        <div class="row">
            <div class="col-11">
                <h1 class="title"><img class="" src="_assets/img/logo4.png">Vitaponik Monitoring</h1> <br>
            </div>
            <div class="col-1" style="position: sticky;"> 
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary position-absolute top-2 end-0 fa fa-info-circle" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                  
                </button>

            </div>
        </div>
     
        <form method="post" action="">       
                <div class="row gx-5 ">
                  <div  class="col-sm-4 py-1 pt-1 card-outside">
                    <div  class="card-content">
                      <div class="card-body">
                        <h4  class="card-title text-center">Water pH</h4>
                        <div class="card-value border rounded-circle">
                            <p id="phair" class="card-value text-center">0</p>
                        </div>
                        <div class="mt-2">
                            <h3 id="hasilphair" class="card-value text-center none">...</h3>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4 py-1 card-outside">
                    <div class="card-content">
                      <div class="card-body">
                        <h4 class="card-title text-center">Temperature</h4>
                        <div class="card-value  border rounded-circle">
                            <p id="temp" class="card-value text-center">0</p>
                        </div>
                        <div class="mt-2">
                            <h3 id="hasilsuhu" class="card-value text-center none">...</h3>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4 py-1 card-outside">
                    <div class="card-content">
                      <div class="card-body">
                        <h4 class="card-title text-center">Humidity</h4>
                        <div class="card-value border rounded-circle">
                            <p id="hum" class="card-value text-center">0</p>
                        </div>
                        <div class=" mt-2">
                            <h3 id="hasilkelembapan" class="text-center none">...</h3>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
        
            <br>

            <div class="card-warning text-center">
              <div class="card-header text-center border-bottom border-#27AE60">
                <h4  class="card-title text-center">Warning</h4>
              </div>
              <div class="card-body mt-10">
                <h1 class="card-title" id="hasil">Waiting </h1>
              </div>
            </div>

            <br>

            <div class="card card-body">
                <h2><b>Fuzzy Logic Mamdani</b></h4>
                <br>
                  <h4><b>1. Fuzzification</b></h4>
                    <p><b>Fuzzification water pH: </b></p>
                    <p id="hasilnilaiphairasam">Acid:</p>
                    <p id="hasilnilaiphairnetral">Netral:</p>
                    <p id="hasilnilaiphairbasa">Alkaline:</p>
                    <br>  
                    <p><b>Fuzzification Temperature: </b></p>
                    <p id="hasilnilaisuhudingin">Cold:</p>
                    <p id="hasilnilaisuhunormal">Normal:</p>
                    <p id="hasilnilaisuhupanas">Hot:</p>
                    <br>
                    <p><b>Fuzzification Humidity: </b></p>
                    <p id="hasilnilaikelembapan">Humid:</p>
                    <p id="hasilnilaisangatlembap">Very Humid:</p>
                    <br>
                 <h4><b>2. Implication Function</b></h4>
                    <p id="aturan_fuzzy"></p>
                    <br>
                 <h4><b>3. Composition Rules</b></h4> 
                    <p id="nilai_sedikit">Normal Condition:</p>
                    <p id="nilai_banyak">Beyond the Limits:</p>
                    <br>
                 <h4><b>4. Defuzzification</b></h4>
                    <p id="coa">Value of warning is (z*): </p>
                </div>
            </div>

            <br>
             
       

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><b>Information</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-align: justify;" style="">
                        <p class="">
                            Water pH levels, temperature, and humidity are constantly changing. Changed conditions can be seen by value, wording, or color:
                        <hr>
                        </p>
                        <p class="text-align: justify;">
                            <b>Water pH</b> <br>
                            <span style="color: #F2C94C">0-5.8 Acid (Yellow)</span>: pH of water is acidic, the user must be neutralized by adding liquid pH up.<br>
                            <span style="color: #6FCF97">5.5-6.5 Netral (Green)</span>: The pH level of the water is normal.<br>
                            <span style="color: #EB5757">6.1-14 Alkaline (Red)</span>: pH of water is alkaline, the user must neutralize it by adding a pH down liquid.
                        </p>
                        <p class="text-align: justify;">
                            <b>Temperature</b> <br>
                            <span style="color: #F2C94C"><0°C-22°C Cold (Yellow): </span>:The environment is in cold temperature conditions, the user must increase the room temperature.<br>
                            <span style="color: #6FCF97">20°C-30°C Normal (Green)</span>: The environment temperature is under normal conditions.<br>
                            <span style="color: #EB5757">28°C-50°C> Hot (Red)</span>: The environment is in hot temperature conditions, the user must lower the room temperature.
                        </p>
                        <p class="text-align: justify;">
                            <b>Humidity</b><br>
                            <span style="color: #6FCF97">0%-85% Humid (Green)</span>: Environmental Humidity under normal conditions.<br>
                            <span style="color: #EB5757">80%-100% Very Humid (Red)</span>: The environment is already very humid.
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

    </div> 

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<!-- 
        The core Firebase JS SDK is always required and must be listed first
        <script src="/__/firebase/8.7.1/firebase-app.js"></script>

        TODO: Add SDKs for Firebase products that you want to use
             https://firebase.google.com/docs/web/setup#available-libraries

        Initialize Firebase
        <script src="/__/firebase/init.js"></script> -->
        
    </div>
</div>

</body>

</html>