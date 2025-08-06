import React from "react";
import HomeHeader from "../../Components/homePage/head/HomeHeader";
import FeaturesCard from "../../Components/homePage/cards/CardFeature";
import Footer from "../../Components/footer/Footer";


const HomePage = () => {
  return (
    <>
      <HomeHeader />
      <FeaturesCard />
      <Footer/>
    </>
  );
};

export default HomePage;
