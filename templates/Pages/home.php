<?php
/**
 * @var \App\View\AppView $this
 */  
$this->assign('title', 'XUAO Inventory Management System');


?>

<?= $this->Html->css('style') ?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Welcome to the Athletics Office IMS</h1>
        <p>Simplifying the management and borrowing of sports equipment for students, teachers, and staff.</p>
        <?= $this->Html->link(__('Request Equipment'), ['controller' => 'Borrowings', 'action' => 'add'], ['class' => 'button button-highlight']) ?>
    </div>
</div>

<!-- Equipment Borrowing Section -->
<section class="borrowing-section">
    <h2 class="section-title">Borrow Sports Equipment</h2>
    <p class="section-subtitle">Students and teachers can easily request and track borrowed sports equipment.</p>
    <div class="borrowing-grid">
        <div class="borrowing-item">
            <img src="img/request.svg" alt="Request Icon">
            <h3>Simple Request Process</h3>
            <p>Submit a request online, check availability, and get approval faster.</p>
        </div>
        <div class="borrowing-item">
            <img src="img/tracking.svg" alt="Tracking Icon">
            <h3>Track Your Requests</h3>
            <p>Monitor the status of your borrowed equipment anytime, anywhere.</p>
        </div>
        <div class="borrowing-item">
            <img src="img/return.svg" alt="Return Icon">
            <h3>Easy Return Management</h3>
            <p>View due dates and return reminders to avoid penalties.</p>
        </div>
    </div>
</section>

<!-- Staff & Admin Section -->
<section class="staff-section">
    <h2 class="section-title">For UAO Staff & Administrators</h2>
    <p class="section-subtitle">Manage sports equipment, monitor requests, and keep track of inventory.</p>
    <div class="staff-grid">
        <div class="staff-item">
            <img src="img/approval.svg" alt="Approval Icon">
            <h3>Manage Requests</h3>
            <p>Approve or reject borrowing requests with ease.</p>
        </div>
        <div class="staff-item">
            <img src="img/inventory.svg" alt="Inventory Icon">
            <h3>Monitor Inventory</h3>
            <p>Track all available, borrowed, and returned sports equipment.</p>
        </div>
        <div class="staff-item">
            <img src="img/report.svg" alt="Report Icon">
            <h3>Generate Reports</h3>
            <p>View borrowing history and generate reports for better management.</p>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="about-container">
        <div class="about-text">
            <h2>About the University Athletics Office</h2>
            <p>The UAO is committed to providing students and faculty with the best sports equipment and facilities to support a vibrant and active university life.</p>
        </div>
        <div class="about-image">
            <img src="img/uao-office.jpg" alt="UAO Office">
        </div>
    </div>
</section>
