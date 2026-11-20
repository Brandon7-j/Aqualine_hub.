<?php
$pageTitle = 'Services | Aqualine Laundry Services';
include 'includes/header.php';

// Fetch live services and rates from aqualine_db
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @new mysqli('127.0.0.1', 'root', '', 'aqualine_db');
$dbServices = [];
$dbError = null;

if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT service_name, unit, unit_price FROM service_items WHERE is_active = 1 ORDER BY service_name ASC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $dbServices[] = $row;
        }
        $res->free();
    } else {
        $dbError = 'Unable to load live service rates right now.';
    }
    $conn->close();
} else {
    $dbError = 'Live database connection is currently unavailable.';
}
?>

<main class="services-main-content">
    <!-- ================= HERO SECTION ================= -->
    <section class="services-hero-section">
        <div class="container">
            <div class="hero-text-content">
                <h1>Freshness Starts Here.</h1>
                <p>Premium Laundry Care, Delivered with Excellence. Explore our Services and Experience the Difference.</p>
                <div class="hero-buttons">
                    <a href="#live-rates" class="primary-button">View Pricing Tiers</a>
                    <a href="http://127.0.0.1:8000" class="secondary-button"><strong>Log In</strong></a>
                </div>
            </div>
            <div class="hero-visual">
                <img src="img/laundry-hero.jpg" alt="Clean, freshly folded laundry at Aqualine Hub" class="hero-image">
            </div>
        </div>
    </section>

    <!-- ================= SERVICES / PRODUCTS GRID ================= -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="section-heading">
                <h2><strong>Our Comprehensive Laundry Services</strong></h2>
                <p>Professional care for your everyday clothing, delicate corporate wear, heavy bedding, and household fabrics across <strong>Madaraka Estate, Nairobi</strong> and neighboring areas.</p>
            </div>

            <div class="services-grid">
                <!-- Service 1 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img src="img/washing-service.jpg" alt="Clothes being washed with care" class="service-image">
                    </div>
                    <div class="service-content">
                        <h3>Professional Washing</h3>
                        <p>
                            Keep your clothes clean and fresh with our advanced washing service. We sort by fabric type and color, utilizing premium detergents to maintain garment integrity.
                        </p>
                        <a href="http://127.0.0.1:8000/customer/dashboard" class="service-link">Request This Service &rarr;</a>
                    </div>
                </article>

                <!-- Service 2 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img src="img/drying-service.jpg" alt="Fresh laundry drying efficiently" class="service-image">
                    </div>
                    <div class="service-content">
                        <h3>Clothes Drying</h3>
                        <p>
                            Get your laundry dried safely using modern tumbling and controlled aeration. Our drying process preserves fabric elasticity and eliminates moisture completely.
                        </p>
                        <a href="http://127.0.0.1:8000/customer/dashboard" class="service-link">Request This Service &rarr;</a>
                    </div>
                </article>

                <!-- Service 3 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img src="img/ironing-service.jpg" alt="Professionally ironed shirts and trousers" class="service-image">
                    </div>
                    <div class="service-content">
                        <h3>Ironing and Pressing</h3>
                        <p>
                            Enjoy crisp, razor-sharp creases suitable for corporate work, university lectures, business meetings, and special occasions. Total boardroom readiness guaranteed.
                        </p>
                        <a href="http://127.0.0.1:8000/customer/dashboard" class="service-link">Request This Service &rarr;</a>
                    </div>
                </article>

                <!-- Service 4 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img src="img/folding-service.jpg" alt="Clean clothes folded neatly" class="service-image">
                    </div>
                    <div class="service-content">
                        <h3>Folding and Packaging</h3>
                        <p>
                            Receive neatly stacked, dust-proof packaged laundry that is effortless to organize, store, and unpack. Perfect for busy professionals and students alike.
                        </p>
                        <a href="http://127.0.0.1:8000/customer/dashboard" class="service-link">Request This Service &rarr;</a>
                    </div>
                </article>

                <!-- Service 5 -->
                <article class="service-card">
                    <div class="service-visual">
                        <img src="img/garment-care.jpg" alt="Delicate clothing being handled carefully" class="service-image">
                    </div>
                    <div class="service-content">
                        <h3>Special Garment Care</h3>
                        <p>
                            Give delicate woolens, silks, traditional regalia, and structured suits specialized dry-cleaning attention with customized solvent treatments.
                        </p>
                        <a href="http://127.0.0.1:8000/customer/dashboard" class="service-link">Request This Service &rarr;</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- ================= LIVE DATABASE PRICING TABLE ================= -->
    <section class="services-section" id="live-rates">
        <div class="container">
            <div class="section-heading">
                <span class="section-label">TRANSPARENT PRICING</span>
                <h2><b>Aqualine Laundry Services &amp; Rates</b></h2>
            </div>

            <div style="overflow-x: auto; background: #F8FAFC; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: #1B4F72; color: #fff;">
                            <th style="padding: 12px;">Service Type</th>
                            <th style="padding: 12px;">Billing Unit</th>
                            <th style="padding: 12px;">Rate (KES)</th>
                            <th style="padding: 12px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($dbError !== null): ?>
                            <tr>
                                <td colspan="4" style="padding: 14px; color: #1B4F72;"><?= htmlspecialchars($dbError) ?></td>
                            </tr>
                        <?php elseif (empty($dbServices)): ?>
                            <tr>
                                <td colspan="4" style="padding: 14px; color: #1B4F72;">No active service rates available at the moment.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($dbServices as $srv): ?>
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 12px; font-weight: 600;"><?= htmlspecialchars($srv['service_name']) ?></td>
                                    <td style="padding: 12px;"><?= htmlspecialchars($srv['unit']) ?></td>
                                    <td style="padding: 12px; font-weight: 700; color: #0F766E;">KES <?= number_format((float)$srv['unit_price'], 2) ?></td>
                                    <td style="padding: 12px;"><a href="http://127.0.0.1:8000/customer/dashboard" class="service-link">Order / Track &rarr;</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="delivery-intro">
        <h2>Convenient Laundry Pickup and Delivery</h2>
        <img src="img/delivery-rider.jpg" alt="Aqualine Laundry Express Motorcycle Delivery" class="featured-img">
        <p><strong>We make your laundry experience simple and stress-free. Drop off your clothes at our laundry centre or contact us to arrange pickup and delivery within our service area. Our team handles your garments with care, keeps you informed about their progress, and prepares them for collection or delivery.</strong></p>
        <a href="contact.php" class="button">Book a Pickup</a>
    </section>

    <section class="delivery-process">
        <h2>How Our Service Works</h2>
        <div class="service-step">
            <h3>1. Book or Drop Off</h3>
        </div>
        <div class="service-step">
            <h3>2. Garment Registration</h3>
        </div>
        <div class="service-step">
            <h3>3. Washing and Processing</h3>
        </div>
        <div class="service-step">
            <h3>4. Order Tracking</h3>
        </div>
        <div class="service-step">
            <h3>5. Payment and Delivery</h3>
            <p><strong>Lipa na M-Pesa, Paybill No 166116</strong></p>
        </div>
    </section>
</main>

<!-- ================= FOOTER ================= -->
<?php include 'includes/footer.php'; ?>