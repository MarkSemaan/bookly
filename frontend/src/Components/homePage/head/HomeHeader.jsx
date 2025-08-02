import React from "react";
import homeImg from "../../../Assets/Images/home.png";
import './homeHeader.css';

const HomeHeader = () => {
  return (
    <section className="welcome-section">
      <div className="left-section">
        <img src={homeImg} alt="Welcome" />
      </div>

      <div className="right-section">
        <div className="welcome-title">
          <h1>Welcome to Bookly</h1>
        </div>
        <div className="welcome-description">
           <p>
    Your personal bookshop on the web. Discover stories that speak to you,
    build your dream shelf, and let your next chapter begin.
  </p>
  <p>
    Curated just for you  whether you're into thrillers, romance, or cozy fantasy. 
    Get comfy and let's find your next favorite read. 
  </p>
        </div>
      </div>
    </section>
  );
};

export default HomeHeader;
