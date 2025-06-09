<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

// Fetch components from database based on categories
$motherboards = $conn->query("SELECT * FROM build_components WHERE category = 'motherboard'")->fetchAll(PDO::FETCH_ASSOC);
$cpus = $conn->query("SELECT * FROM build_components WHERE category = 'cpu'")->fetchAll(PDO::FETCH_ASSOC);
$gpus = $conn->query("SELECT * FROM build_components WHERE category = 'gpu'")->fetchAll(PDO::FETCH_ASSOC);
$rams = $conn->query("SELECT * FROM build_components WHERE category = 'ram'")->fetchAll(PDO::FETCH_ASSOC);
$power_supplies = $conn->query("SELECT * FROM build_components WHERE category = 'power_supply'")->fetchAll(PDO::FETCH_ASSOC);
$cpu_coolers = $conn->query("SELECT * FROM build_components WHERE category = 'cpu_cooler'")->fetchAll(PDO::FETCH_ASSOC);
$storages = $conn->query("SELECT * FROM build_components WHERE category = 'storage'")->fetchAll(PDO::FETCH_ASSOC);
$cases = $conn->query("SELECT * FROM build_components WHERE category = 'case'")->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Build Your PC</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .build-container {
         display: flex;
         gap: 2rem;
         padding: 2rem;
      }
      .parts-section {
         flex: 1;
      }
      .details-panel {
         flex: 0 0 400px;
         position: sticky;
         top: 2rem;
         height: 600px;
         padding: 2rem;
         background: #fff;
         border-radius: 8px;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
         overflow-y: auto;
      }
      .component-details {
         text-align: center;
         word-wrap: break-word;
         overflow-wrap: break-word;
      }
      .component-details img {
         max-width: 100%;
         height: auto;
         max-height: 300px;
         object-fit: contain;
         margin-bottom: 1rem;
      }
      .component-details h3 {
         margin: 1rem 0;
         font-size: 1.2rem;
         word-wrap: break-word;
         padding: 0 1rem;
      }
      .component-details .price {
         font-size: 1.2rem;
         color: #2980b9;
         margin: 1rem 0;
      }
      .component-details .description {
         text-align: left;
         line-height: 1.6;
         padding: 0 1rem;
         word-wrap: break-word;
         white-space: normal;
         width: 100%;
      }
   </style>

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- build your PC section starts -->
<div class="heading">
   <h3>Build Your Own PC</h3>
</div>
<div class="build-container">
   <div class="parts-section">
      <h1 class="title">Choose with your budget and Preferences</h1>
      <form action="print_build.php" method="POST">   
         <div class="component-select">
            <h2>Motherboard</h2>
            <select name="motherboard" required>
               <option value="" disabled selected>Select Motherboard</option>
               <?php foreach ($motherboards as $mb) : ?>
                  <option value="<?= $mb['id'] ?>"><?= $mb['name'] ?> - RM <?= $mb['price'] ?></option>
               <?php endforeach; ?>
            </select>
         </div>

         <!-- CPU Selection -->
         <div class="component-select">
            <h2>CPU</h2>
            <select name="cpu" required>
               <option value="" disabled selected>Select CPU</option>
               <!-- Options will be dynamically populated -->
            </select>
         </div>

         <!-- GPU Selection -->
         <div class="component-select">
            <h2>GPU</h2>
            <select name="gpu" required>
               <option value="" disabled selected>Select GPU</option>
               <!-- Options will be dynamically populated -->
            </select>
         </div>

         <!-- RAM Selection -->
         <div class="component-select">
            <h2>RAM</h2>
            <select name="ram" required>
               <option value="" disabled selected>Select RAM</option>
               <!-- Options will be dynamically populated -->
            </select>
         </div>

         <!-- Storage Selection -->
         <div class="component-select">
            <h2>Storage</h2>
            <select name="storage" required>
               <option value="" disabled selected>Select Storage</option>
               <!-- Options will be dynamically populated -->
            </select>
         </div>

         <!-- Power Supply Selection -->
         <div class="component-select">
            <h2>Power Supply</h2>
            <select name="power supply" required>
               <option value="" disabled selected>Select Power Supply</option>
               <!-- Options will be dynamically populated -->
            </select>
         </div>

         <!-- CPU Cooler Selection -->
         <div class="component-select">
            <h2>CPU Cooler</h2>
            <select name="cooler" required>
               <option value="" disabled selected>Select CPU Cooler</option>
               <!-- Options will be dynamically populated -->
            </select>
         </div>

         <!-- Case Selection -->
         <div class="component-select">
            <h2>Case</h2>
            <select name="case" required>
               <option value="" disabled selected>Select Case</option>
               <!-- Options will be dynamically populated -->
            </select>
         </div>

         <!-- Print PDF Button -->
         <div class="print-button">
            <button type="button" class="btn" id="print-button">Print PDF</button>
         </div>
      </form>
   </div>
   
   <div class="details-panel">
      <div class="component-details">
         <h3>Select a component to view details</h3>
      </div>
   </div>
</div>

</body>
    <?php include 'components/footer.php'; ?>
</html>
<script>
      document.querySelectorAll('select').forEach(select => {
         select.addEventListener('change', async function() {
            const componentId = this.value;
            const category = this.name;
            
            try {
               const response = await fetch(`get_component_details.php?id=${componentId}`);
               const data = await response.json();
               
               const detailsPanel = document.querySelector('.component-details');
               detailsPanel.innerHTML = 
                  `<img src="uploaded_img/${data.image}" alt="${data.name}">` +
                  `<h3>${data.name}</h3>` +
                  `<div class="price">RM ${data.price}</div>` +
                  `<div class="description">${data.details}</div>`;
            } catch (error) {
               console.error('Error fetching component details:', error);
            }
         });
      });

      // New script for fetching compatible components
      document.querySelector('select[name="motherboard"]').addEventListener('change', async function () {
          const motherboardId = this.value;

          try {
              // Fetch compatible components based on motherboard ID
              const response = await fetch(`get_compatible_components.php?motherboard_id=${motherboardId}`);
              const data = await response.json();

              // Populate compatible categories
              ['cpu', 'gpu', 'ram', 'power supply', 'cooler', 'case'].forEach(category => {
                  const select = document.querySelector(`select[name="${category}"]`);
                  select.innerHTML = '<option value="" disabled selected>Select ' + category.replace('_', ' ') + '</option>';
                  data[category].forEach(component => {
                      select.innerHTML += `<option value="${component.id}">${component.name} - RM ${component.price}</option>`;
                  });
              });

              // Populate all storage options (not filtered by compatibility)
              const storageSelect = document.querySelector(`select[name="storage"]`);
              storageSelect.innerHTML = '<option value="" disabled selected>Select storage</option>';
              data.storage.forEach(storage => {
                  storageSelect.innerHTML += `<option value="${storage.id}">${storage.name} - RM ${storage.price}</option>`;
              });
          } catch (error) {
              console.error('Error fetching compatible components:', error);
          }
      });

      // New function to handle print button click
      document.getElementById('print-button').addEventListener('click', function() {
          const selectedComponents = {
              motherboard: document.querySelector('select[name="motherboard"]').value,
              cpu: document.querySelector('select[name="cpu"]').value,
              gpu: document.querySelector('select[name="gpu"]').value,
              ram: document.querySelector('select[name="ram"]').value,
              storage: document.querySelector('select[name="storage"]').value,
              power_supply: document.querySelector('select[name="power supply"]').value,
              cooler: document.querySelector('select[name="cooler"]').value,
              case: document.querySelector('select[name="case"]').value,
          };

          // Redirect to print_build.php with selected components as query parameters
          const queryString = new URLSearchParams(selectedComponents).toString();
          window.location.href = `print_build.php?${queryString}`;
      });
</script>

<script src="js/script.js"></script>