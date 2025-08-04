import React from "react";
import { Outlet } from "react-router-dom";
import Navbar from "../Navbar/Navbar";
import "./AppLayout.css"; 
import Footer from "../../footer/Footer";

const AppLayout = () => {
  return (
    <div className="layout-wrapper">
      <Navbar />
      <div className="main-content">
        <Outlet />
      </div>
      <Footer />
    </div>
  );
};

export default AppLayout;
