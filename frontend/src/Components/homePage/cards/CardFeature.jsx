import React from "react";
import FeaturesCard from "./Cards";
import HomeCar from "../../../Assets/Icons/HomeCar.svg";
import HomeBooks from "../../../Assets/Icons/HomeBooks.svg";
import HomeCheckout from "../../../Assets/Icons/HomeCheckout.svg";
import booklist from "../../../Assets/Images/booklist.jpg";
import "./cards.css";

const Features = () => {
  return (
    <>
      <div className="features-section">
        <FeaturesCard
          image={HomeBooks}
          title="Huge Library"
          description="Browse thousands of books across every genre, from timeless classics to trending new releases."
        />
        <FeaturesCard
          image={HomeCheckout}
          title="Easy Checkout"
          description="Enjoy a smooth, secure checkout process with multiple payment options tailored for you."
        />
        <FeaturesCard
          image={HomeCar}
          title="Fast Delivery"
          description="Receive your books quickly and reliably, right to your doorstep, no stress involved."
        />
      </div>

      <div className="imageSteps">
        <img src={booklist} alt="Book List Preview" />
      </div>
    </>
  );
};

export default Features;
