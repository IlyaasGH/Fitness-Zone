<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Fitness Zone</title>
    <link rel="stylesheet" href="style.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: white;
        }

        section {
            margin-bottom: 10px;
            padding: 20px;
            text-align: justify;
        }

        h2 {
            color: orangered;
            margin-bottom: 10px;
        }

        .about-container {
            text-align: center;
            padding: 50px 20px;
        }

        .about-container h1 {
            font-size: 3rem;
            color: #cc0000;
        }

        .about-container p {
            font-size: 1.2rem;
            color: #555;
            line-height: 1.8;
            margin: 20px auto;
            max-width: 800px;
        }

        .achievements-container {
            margin: 40px 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .achievement {
            background-color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 250px;
            border-radius: 10px;
            text-align: center;
        }

        .achievement h2 {
            font-size: 2rem;
            color: #cc0000;
        }

        .achievement p {
            font-size: 1rem;
            color: #333;
        }

        .equipments-container {
            padding: 50px 20px;
            background-color: black;
            color: white;
        }

        .equipments-container h2 {
            font-size: 2.5rem;
            color: #cc0000;
            margin-bottom: 20px;
        }

        .equipment-list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .equipment {
            width: 300px;
            background-color: #f4f4f4;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
        }

        .equipment h3 {
            font-size: 1.5rem;
            color: #333;
        }

        .equipment img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .equipment-p-color {
            color: black;
        }

        .customer-reviews-section {
            padding: 40px;
            background-color: black;
            text-align: center;
        }

        .reviews-carousel {
            display: flex;
            overflow: hidden;
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .review-item {
            flex: 0 0 100%;
            animation: moveReviews 35s linear infinite;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 10px;
            color: black;
        }

        @keyframes moveReviews {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(-200%);
            }

            75% {
                transform: translateX(-300%);
            }

            100% {
                transform: translateX(0);
            }
        }

        .submit-review-section {
            padding: 20px;
            background-color: black;
            text-align: center;
        }

        .review-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
            margin: 0 auto;
        }

        .review-form input,
        .review-form textarea {
            width: 94%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .review-form button {
            padding: 10px;
            background-color: orangered;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .review-form button:hover {
            background-color: orange;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="header-left">
                <img src="logo/logo.png" alt="Fitness Zone Logo" class="logo" style="height: 80px;">
            </div>
        </div>
    </header>

    <div class="about-container">
        <h1>About Fitness Zone</h1>
        <p>Welcome to **Fitness Zone**, the ultimate destination for fitness enthusiasts since <strong>2010</strong>.
            With a legacy spanning over a decade, we’ve helped thousands achieve their fitness goals and live healthier, happier lives.
            We pride ourselves on offering world-class facilities, cutting-edge equipment, and personalized training programs tailored to every individual.</p>
    </div>

    <section class="achievements-container">
        <div class="achievement">
            <h2>10,000+</h2>
            <p>Happy Customers</p>
        </div>
        <div class="achievement">
            <h2>14</h2>
            <p>Years of Excellence</p>
        </div>
        <div class="achievement">
            <h2>50+</h2>
            <p>Professional Trainers</p>
        </div>
        <div class="achievement">
            <h2>20+</h2>
            <p>Fitness Awards Won</p>
        </div>
    </section>

    <section class="customer-reviews-section">
        <h2>What Our Customers Say</h2>
        <div class="reviews-carousel">
            <div class="review-item">
                <p>"The best gym experience I've ever had! Highly recommend!"</p>
                <h4>- John Doe</h4>
            </div>
            <div class="review-item">
                <p>"Amazing trainers and top-notch facilities. Love it!"</p>
                <h4>- Jane Smith</h4>
            </div>
            <div class="review-item">
                <p>"Great environment and community. My fitness journey has been transformed!"</p>
                <h4>- Mike Johnson</h4>
            </div>
            <div class="review-item">
                <p>"Affordable pricing and excellent support. Five stars!"</p>
                <h4>- Emily Davis</h4>
            </div>
        </div>
    </section>


    <section class="submit-review-section">
        <h2>Write a Review</h2>
        <form class="review-form">
            <input type="text" name="name" placeholder="Your Name" required />
            <textarea name="review" rows="4" placeholder="Your Review" required></textarea>
            <div class="star-rating">
                <span class="star" data-value="1">&#9734;</span>
                <span class="star" data-value="2">&#9734;</span>
                <span class="star" data-value="3">&#9734;</span>
                <span class="star" data-value="4">&#9734;</span>
                <span class="star" data-value="5">&#9734;</span>
            </div>
            <input type="hidden" name="rating" id="rating-input" />
            <button type="submit">Submit Review</button>
        </form>
    </section>

    <section class="equipments-container">
        <h2>State-of-the-Art Equipment</h2>
        <div class="equipment-list">
            <div class="equipment">
                <h3>Cardio Machines</h3>
                <img src="image/weight.jpg" alt="Cardio Machines">
                <p class="equipment-p-color">Top-notch treadmills, ellipticals, and bikes to elevate your heart rate and boost endurance.</p>
            </div>
            <div class="equipment">
                <h3>Weightlifting</h3>
                <img src="image/wl.jpg" alt="Weightlifting Equipment">
                <p class="equipment-p-color">Dumbbells, barbells, and resistance machines for strength training.</p>
            </div>
            <div class="equipment">
                <h3>Yoga Studio</h3>
                <img src="image/yoga.jpg" alt="Yoga Studio">
                <p class="equipment-p-color">A serene space for yoga, pilates, and stretching exercises.</p>
            </div>
            <div class="equipment">
                <h3>Functional Training</h3>
                <img src="image/ft.jpg" alt="Functional Training">
                <p class="equipment-p-color">TRX systems, kettlebells, and ropes to add versatility to your workout.</p>
            </div>
        </div>
    </section>

    <section id="gym">
        <h2>GYM</h2>
        <p>Our gym is designed to cater to all fitness levels, providing state-of-the-art machines, free weights, and functional training equipment. Members can take advantage of personalized workout plans and group sessions guided by certified trainers, ensuring a safe and effective fitness journey in a supportive environment.</p>
    </section>

    <section id="zumba">
        <h2>Zumba</h2>
        <p>Zumba is a fun and energetic dance workout that blends Latin and international music with cardio-based moves. Our certified instructors lead sessions tailored for all fitness levels, helping members burn calories and improve endurance while enjoying an engaging, party-like atmosphere.</p>
    </section>

    <section id="personal-training">
        <h2>Personal Training</h2>
        <p>Personal training offers a customized fitness experience, where members work one-on-one with certified professionals to meet their unique goals. Our trainers create tailored workout routines, provide nutrition advice, and offer motivation to ensure maximum progress in a focused setting.</p>
    </section>

    <section id="group-class">
        <h2>Group Class</h2>
        <p>Our group classes include a variety of options like yoga, HIIT, spinning, and more. These sessions are designed to keep members motivated by blending high-energy workouts with the camaraderie of group participation, all under the guidance of experienced instructors.</p>
    </section>

    <section id="healthy-cafe">
        <h2>Healthy Cafe</h2>
        <p>Our Healthy Cafe serves as the perfect spot for post-workout recovery or a quick, nutritious snack. With a range of protein shakes, healthy snacks, and balanced meal options, the cafe complements your fitness goals by offering fuel for energy and recovery.</p>
    </section>

    <section id="meal-plan">
        <h2>Meal Plan</h2>
        <p>Tailored meal plans are a cornerstone of holistic fitness. Our dietitians craft personalized nutrition programs to match each member's goals, whether it's weight loss, muscle gain, or maintenance. These plans are designed to integrate seamlessly into a healthy and active lifestyle.</p>
    </section>

    <section id="workout-plan">
        <h2>Workout Plan</h2>
        <p>Structured workout plans are created based on individual fitness assessments to help members achieve their goals. These routines provide a clear path for progress, incorporating strength, endurance, and flexibility exercises under the guidance of expert trainers.</p>
    </section>

    <section id="cardio">
        <h2>Cardio</h2>
        <p>Cardio training focuses on improving heart health and burning calories through exercises like running, cycling, or rowing. With access to a variety of equipment, our members can enjoy effective, high-energy workouts to boost stamina and overall fitness.</p>
    </section>

    <footer1>
        <p style="text-align: center; padding: 20px; color: #555;">© 2024 Fitness Zone. All Rights Reserved.</p>
    </footer1>

    <script>
        // Star Rating Script
        document.addEventListener("DOMContentLoaded", () => {
            const stars = document.querySelectorAll(".star");
            const ratingInput = document.getElementById("rating-input");

            stars.forEach((star) => {
                star.addEventListener("click", () => {
                    stars.forEach((s) => s.classList.remove("selected"));
                    star.classList.add("selected");

                    // Highlight all stars up to the selected one
                    const value = star.getAttribute("data-value");
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add("selected");
                    }
                    ratingInput.value = value; // Set rating value in hidden input
                });
            });
        });
    </script>
</body>

</html>