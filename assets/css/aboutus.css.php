<style>
    /* General Styling */
    body {
      font-family: 'Arial', sans-serif;
      line-height: 1.6;
    }
    h1, h2 {
      font-weight: bold;
    }

    /* Banner Section */
    .banner {
      background: url('https://via.placeholder.com/1920x400') no-repeat center center/cover;
      height: 400px;
      position: relative;
      color: white;
    }
    .banner-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      background: rgba(0, 0, 0, 0.5);
      padding: 20px 40px;
      border-radius: 10px;
      animation: fadeIn 2s ease-in-out;
    }
    .banner-text h1 {
      font-size: 3rem;
      margin-bottom: 10px;
    }
    .banner-text p {
      font-size: 1.5rem;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    /* About Section */
    .about-section {
      background-color: #f8f9fa;
      padding: 60px 0;
      text-align: center;
    }
    .about-section p.lead {
      font-size: 1.25rem;
      color: #555;
    }
    .about-section hr {
      width: 50px;
      border-top: 3px solid #007bff;
      margin: 20px auto;
    }

    /* Vision Section */
    .vision-section {
      background-color: #e9ecef;
      padding: 60px 0;
      text-align: center;
    }
    .vision-section h2 {
      margin-bottom: 20px;
    }
    .vision-section p {
      max-width: 700px;
      margin: 0 auto;
      font-size: 1.2rem;
      color: #555;
    }

    /* Team Section */
    .team-section {
      background-color: #343a40;
      color: white;
      padding: 60px 0;
      text-align: center;
    }
    .team-member {
      margin-bottom: 30px;
    }
    .team-member img {
      border-radius: 50%;
      width: 150px;
      height: 150px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }
    .team-member img:hover {
      transform: scale(1.1);
    }
    .team-member h5 {
      font-size: 1.5rem;
      font-weight: bold;
      margin-top: 15px;
    }
    .team-member p {
      font-style: italic;
      font-size: 1.1rem;
    }
  </style>