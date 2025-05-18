<?= $this->Html->css('dashboardBorrower') ?>

<div class="dashboard-container">
    <h1>Borrower Dashboard</h1>
    <p class="greeting">Hello, <?= h($this->request->getAttribute('identity')->name) ?>! Welcome to your dashboard.</p>

    <div class="section user-info">
        <h2>Your Information</h2>
        <p><strong>Name:</strong> <?= h($this->request->getAttribute('identity')->name) ?></p>
        <p><strong>Email:</strong> <?= h($this->request->getAttribute('identity')->email) ?></p>
    </div>

    <div class="section uao-info">
        <h2>University Athletics Office (UAO)</h2>
        <p><strong>Location:</strong> 3rd Floor, Xavier Gym Complex</p>
        <p><strong>Background:</strong> The UAO manages sports facilities and equipment to support student-athletes and employees. We aim to promote organized, responsible borrowing of sports gear.</p>
        <div class="uao-image">
            <img src="/uploads/uao_office.jpg" alt="UAO Office Photo">
        </div>
    </div>

    <div class="section uao-contact">
        <h2>UAO Contact Information</h2>
        <p><strong>Office:</strong> Xavier University Gym, Corrales Avenue, Cagayan de Oro City</p>
        <p><strong>Email:</strong> <a href="mailto:jesparrago@xu.edu.ph">jesparrago@xu.edu.ph</a></p>
        <p><strong>Phone:</strong> (088) 853-9800 Local 9842 / 9219</p>
        <p><strong>Website:</strong> <a href="http://www.xu.edu.ph/university-athletics-office" target="_blank">Visit UAO Website</a></p>
    </div>

    <div class="section instructions">
        <h2>How to Borrow Equipment</h2>
        <ol>
            <li>Go to the Borrow page and fill out the request form</li>
            <li>Upload a valid ID image (student or employee ID)</li>
            <li>Wait for admin approval</li>
            <li>Return the item before the set return date/time</li>
            <li>Report any damage or issues when returning</li>
        </ol>
    </div>

</div>
