<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application Form</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
        <link rel="icon" href="<?= base_url('assets/images/alsticon.ico') ?>" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Navigation Bar -->


<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo" height="70" class="me-2">
            <span class="brand-name fs-1">ALLSTAR TECH INTERNET</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Application Form Section -->
<div class="app-form d-flex justify-content-center align-items-center">
    <div class="app-card">
        <h2 class="text-center">Application Form</h2><hr>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php $selectedPlan = isset($_GET['plan']) ? $_GET['plan'] : ''; ?>
        <form action="<?= base_url('submit-application') ?>" method="POST">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
            <div class="container mt-4">
                <label class="form-label"> Personal Information </label>
                <div class="row">
                    <div class="form-floating col-md-3">
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                        <label for="first_name">First Name:</label>
                    </div>
                    <div class="form-floating col-md-3">
                        <input type="text" class="form-control" id="middle_name" name="middle_name" required> 
                        <label for="middle_name">Middle Name:</label>
                    </div>
                    <div class="form-floating col-md-3">
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                        <label for="last_name">Last Name:</label>
                    </div>
                    <div class="form-floating col-md-3" style="margin-top: -25px;"><br>
                        <select type="text" class="form-select" id="suffix" name="suffix">
                            <option selected></option>
                             <option value="">N/A</option>
                             <option value="Sr">Sr</option>
                             <option value="Jr">Jr</option>
                             <option value="III">III</option>
                             <option value="IV">IV</option>
                        </select>
                        <label for="suffix">Suffix:</label>
                    </div>
                </div>
            </div><hr>


        <div class="row g-3">
        <label class="form-label"> Address Information</label>
            <!-- Province Dropdown -->
            <div class="form-floating col-md-4">
                <select class="form-select" id="province" name="province">
                    <option value=""></option>
                </select>
                <label for="province">Province:</label>
                <!-- Hidden input to store selected province name -->
                <input type="hidden" name="selectedProvince" id="selectedProvince">
            </div>
                <!-- City Dropdown -->
            <div class="form-floating col-md-4">
                <select class="form-select" id="city" name="city">
                    <option value=""></option>
                </select>
                <label for="city">City:</label>
            </div>
                <!-- Barangay Dropdown -->
            <div class="form-floating col-md-4">
                <input type="text" class="form-control" id="barangay" name="barangay" required>
                <label for="barangay">Barangay:</label>
            </div>
        </div> <br>
        <div class="row">
            <!-- Landmark -->
            <div class="form-floating col-md-6">
                        <input type="text" class="form-control" id="house_number" name="house_number">
                        <label for="house_number">House Number:</label>
                    </div>
            <div class="form-floating col-md-6">
                        <input type="text" class="form-control" id="apartment" name="apartment">
                        <label for="apartment">Apartment, suite, etc.</label>
                    </div> 
            <div class="form-floating col-md-12"><br>
                        <input type="text" class="form-control" id="landmark" name="landmark" required>
                        <label for="landmark">Landmark:</label>
                    </div> 
        </div><hr>
        <div class="row">
        <label class="form-label"> Contact Information</label>
            <div class="form-floating col-md-6">
                        <input type="text" class="form-control" id="contact_number1" name="contact_number1" required>
                        <label for="contact_number1">Contact 1:</label>
                    </div>
            <div class="form-floating col-md-6">
                        <input type="text" class="form-control" id="contact_number2" name="contact_number2">
                        <label for="contact_number2">Contact 2:</label>
                    </div> 
            <div class="form-floating col-md-12"><br>
                        <input type="email" class="form-control" id="email" name="email" required> 
                        <label for="email">Email Adress</label>
                    </div> 
        </div><br><hr>
            <!-- Plans -->
            <label class="form-label">Plan </label>
            <div class="form-floating mb-3">
                <select class="form-select" id="plan" name="plan" required>
                    <option value=""></option>
                    <option value="50" <?= $selectedPlan === '50 Mbps - ₱799/month' ? 'selected' : '' ?>>50 Mbps - ₱799/month</option>
                    <option value="100" <?= $selectedPlan === '100 Mbps - ₱999/month' ? 'selected' : '' ?>>100 Mbps - ₱999/month</option>
                    <option value="130" <?= $selectedPlan === '130 Mbps - ₱1299/month' ? 'selected' : '' ?>>130 Mbps - ₱1299/month</option>
                    <option value="150" <?= $selectedPlan === '150 Mbps - ₱1499/month' ? 'selected' : '' ?>>150 Mbps - ₱1499/month</option>
                </select>
                <label for="plan">Select Plan</label>
            </div>

            <button type="submit" class="btn btn-danger w-100">Submit Application</button>
        </form>
    </div>
</div>

<?= view('footer') ?>

<script>
    $(document).ready(function(){
    // Load provinces on page load
   $.ajax({
    url: "<?= site_url('location/getProvinces') ?>",
    type: "GET",
    success: function(response) {
        $('#province').html('<option value="">Select Province</option>');

        const allowedProvinces = ["Bulacan", "Pampanga", "Bataan"];

        $.each(response, function(index, province) {
            if (allowedProvinces.includes(province.name)) {
                $('#province').append('<option value="'+province.name+'" data-code="'+province.code+'">'+province.name+'</option>');
            }
        });
    }
});

    $('#province').change(function(){
    var provinceCode = $(this).find(':selected').data('code');
    var provinceName = $(this).val();
    $('#selectedProvince').val(provinceName);

    if(provinceCode) {
        $.ajax({
            url: "<?= site_url('location/getCities') ?>",
            type: "GET",
            data: {province_code: provinceCode},
            success: function(response) {
                $('#city').html('<option value="">Select City</option>');

                // Custom city filters per allowed province
                const cityFilters = {
                    "Bulacan": ["City of Malolos", "Hagonoy", "Paombong", "Guiguinto"],
                    "Pampanga": ["City of San Fernando", "City of Angeles", "Mabalacat City"],
                    "Bataan": ["Mariveles", "Orani", "Dinalupihan", "City of Balanga"]
                };

                const allowedCities = cityFilters[provinceName] || [];

                $.each(response, function(index, city) {
                    if (allowedCities.includes(city.name)) {
                        $('#city').append('<option value="'+city.name+'" data-code="'+city.code+'">'+city.name+'</option>');
                    }
                });
            }
        });
    } else {
        $('#city').html('<option value="">Select City</option>');
    }
});

    // Load barangays when city is selected
});

</script>


</body>
</html>