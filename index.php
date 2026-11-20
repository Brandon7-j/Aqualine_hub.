<?php
$pageTitle = 'Home | Aqualine Laundry Services';
include 'includes/header.php';

// Connect to aqualine_db to sync live services & customer login/order activity
$conn = new mysqli('127.0.0.1', 'root', '', 'aqualine_db');
$liveServices = [];
$activeCustomersCount = 0;
$recentCustomerName = null;

if (!$conn->connect_error) {
    // 1. Fetch active services & KES pricing
    $srvRes = $conn->query("SELECT service_name, unit, unit_price FROM service_items WHERE is_active = 1 ORDER BY service_name ASC LIMIT 6");
    if ($srvRes) {
        while ($row = $srvRes->fetch_assoc()) {
            $liveServices[] = $row;
        }
    }

    // 2. Fetch live customer count & most recent customer login from database
    $custRes = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'customer' AND status = 'active'");
    if ($custRes && $cRow = $custRes->fetch_assoc()) {
        $activeCustomersCount = (int) $cRow['total'];
    }

    $recentRes = $conn->query("SELECT full_name FROM users WHERE role = 'customer' AND last_login_at IS NOT NULL ORDER BY last_login_at DESC LIMIT 1");
    if ($recentRes && $rRow = $recentRes->fetch_assoc()) {
        $recentCustomerName = $rRow['full_name'];
    }

    $conn->close();
}
?>

<main>
    <!-- ================= HERO SECTION ================= -->
    <section class="hero-section" id="home">
        <div class="container hero-content">
            <div class="hero-text">
                <p class="section-label">SMART CARE FOR YOUR EVERYDAY WEAR</p>
                <h1>Fresh, Crisp Laundry Without the Hassle</h1>
                <p class="hero-description">
                    Experience professional laundry care designed around your lifestyle in Madaraka, Nairobi.
                    Track your garments in real time from drop-off to ready for pickup.
                </p>
                <div class="hero-buttons">
                    <a href="http://127.0.0.1:8000" class="primary-button">
                        <strong>Log In</strong>
                    </a>
                    <a href="services.php" class="secondary-button">
                        Explore Our Services
                    </a>
                </div>
            </div>

            <div class="hero-visual">
                <img
                    src="img/laundry-hero.jpg"
                    alt="Clean, freshly folded laundry"
                    class="hero-image"
                >
            </div>
        </div>
    </section>

    <!-- ================= SERVICES / PRODUCTS ================= -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="section-heading">
                <p class="section-label">WHAT WE OFFER</p>
                <h2>Our Laundry Services</h2>
                <p>
                    Professional care for your everyday clothing,
                    delicate garments, and household fabrics.
                </p>
            </div>

            <div class="services-grid">
                <!-- Service 1 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img
                            src="img/washing-service.jpg"
                            alt="Clothes being washed"
                            class="service-image"
                        >
                    </div>
                    <div class="service-content">
                        <h3>Professional Washing</h3>
                        <p>
                            Keep your clothes clean and fresh with
                            our professional washing service. We
                            handle different fabrics carefully to
                            help maintain their quality.
                        </p>
                        <a href="http://127.0.0.1:8000" class="service-link">
                            Track or Book in Portal &rarr;
                        </a>
                    </div>
                </article>

                <!-- Service 2 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img
                            src="img/drying-service.jpg"
                            alt="Fresh laundry drying"
                            class="service-image"
                        >
                    </div>
                    <div class="service-content">
                        <h3>Clothes Drying</h3>
                        <p>
                            Get your laundry dried conveniently
                            and professionally. Our drying service
                            helps you prepare your clothes for
                            folding, ironing, or storage.
                        </p>
                        <a href="http://127.0.0.1:8000" class="service-link">
                            Track or Book in Portal &rarr;
                        </a>
                    </div>
                </article>

                <!-- Service 3 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img
                            src="img/ironing-service.jpg"
                            alt="Professionally ironed clothes"
                            class="service-image"
                        >
                    </div>
                    <div class="service-content">
                        <h3>Ironing and Pressing</h3>
                        <p>
                            Enjoy neatly pressed clothes suitable
                            for work, school, meetings, and special
                            occasions. We help your garments look
                            clean, smooth, and presentable.
                        </p>
                        <a href="http://127.0.0.1:8000" class="service-link">
                            Track or Book in Portal &rarr;
                        </a>
                    </div>
                </article>

                <!-- Service 4 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img
                            src="img/folding-service.jpg"
                            alt="Clean clothes folded neatly"
                            class="service-image"
                        >
                    </div>
                    <div class="service-content">
                        <h3>Folding and Packaging</h3>
                        <p>
                            Receive neatly folded laundry that
                            is easy to organise, store, and carry.
                            Our finishing process gives your
                            clothes a clean, organised appearance.
                        </p>
                        <a href="http://127.0.0.1:8000" class="service-link">
                            Track or Book in Portal &rarr;
                        </a>
                    </div>
                </article>

                <!-- Service 5 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img
                            src="img/garment-care.jpg"
                            alt="Clothing being handled carefully"
                            class="service-image"
                        >
                    </div>
                    <div class="service-content">
                        <h3>Special Garment Care</h3>
                        <p>
                            Give delicate and special garments
                            extra attention. We assess the care
                            requirements of your items before
                            recommending an appropriate service.
                        </p>
                        <a href="http://127.0.0.1:8000" class="service-link">
                            Track or Book in Portal &rarr;
                        </a>
                    </div>
                </article>
            </div>

            <!-- Live Database Rates Preview -->
            <?php if (!empty($liveServices)): ?>
                <div style="margin-top: 2.5rem; text-align: center;">
                    <p class="section-label">CURRENT SYSTEM RATES</p>
                    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-top: 12px;">
                        <?php foreach ($liveServices as $item): ?>
                            <span style="background: #ffffff; border: 1px solid #dce4e8; padding: 8px 14px; border-radius: 6px; font-size: 0.9rem;">
                                <strong><?= htmlspecialchars($item['service_name']) ?>:</strong>
                                KES <?= number_format((float)$item['unit_price'], 0) ?> (<?= htmlspecialchars($item['unit']) ?>)
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <div style="margin-top: 16px;">
                        <a href="services.php#live-rates" class="service-link">View Full Rate Card &rarr;</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ================= ABOUT SECTION ================= -->
    <section class="about-section" id="about">
        <div class="container about-content">
            <div class="about-visual">
                <img
                    src="img/laundry-team.jpg"
                    alt="Laundry professionals at work"
                    class="about-image"
                >
            </div>

            <div class="about-text">
                <p class="section-label">ABOUT AQUALINE</p>
                <h2>Care You Can Trust</h2>
                <p>
                    At Aqualine Laundry, we understand that clean
                    clothes contribute to comfort, confidence, and
                    a well-organised lifestyle.
                </p>
                <p>
                    Our goal is to make laundry care convenient
                    through attentive service, careful garment
                    handling, and a commitment to customer
                    satisfaction.
                </p>
            </div>
        </div>
    </section>

<section>
        <h2>About Aqualine Laundry</h2>
        <p>Aqualine laundry was started in December 2023, by <strong>Brandon Ochieng and Jama Bashir.</strong></p>
        <p>Aqualine Laundry was conceptualized to address the heavy reliance on manual, paper-based record-keeping in local laundry and dry-cleaning small-and-medium enterprises (SMEs).</p>
        <p>By shifting to our digital web application, businesses eliminate garment mix-ups, missing paper slips, and delayed tracking—delivering total peace of mind to our customers.</p>
        
        <!-- Storefront Image placed prominently within the main body -->
        <div class="hero-image-container">
            <img src="img/laundry-exterior.jpg" alt="Aqualine Laundry Services - Outside View" class="featured-img">
        </div>
          <h3>Core Principles</h3>
        <ol>
            <li>Transparent Garment Tracking</li>
            <li>Data Privacy & Security</li>
            <li>Seamless M-Pesa Integration</li>
        </ol>   
        </section>

    <!-- ================= CONTACT SECTION ================= -->
    <section class="contact-section" id="contact">
        <div class="container contact-content">
            <div class="section-heading">
                <p class="section-label">GET STARTED</p>
                <h2>Let Us Handle Your Laundry</h2>
                <p>Contact our team to ask about our services, prices, and how to arrange your laundry.</p>
            </div>

            <div class="contact-details">
                <div class="contact-item">
                    <h3>Visit Us</h3>
                    <p>Aqualine Laundry, Madaraka.</p>
                </div>
                <div class="contact-item">
                    <h3>Call Us</h3>
                    <p><a href="tel:+254116558929">+254 116 558 929</a></p>
                </div>
                <div class="contact-item">
                    <h3>Email Us</h3>
                    <p><a href="mailto:info@aqualaundry.com">info@aqualaundry.com</a></p>
                </div>
            </div>

            <div class="hero-buttons" style="justify-content: center; margin-top: 20px;">
                <a href="mailto:info@aqualaundry.com" class="primary-button">
                    Email Aqualine
                </a>
               
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>