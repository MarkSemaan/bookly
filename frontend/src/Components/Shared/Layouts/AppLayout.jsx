import React from "react";
import { Outlet } from "react-router-dom";
import Navbar from "../Navbar/Navbar";
import "./AppLayout.css"; 



const AppLayout = () => {
  return (
    <div>
      <Navbar />
        <div className="main-content">
          <Outlet />
        </div>
    </div>
  );
};

export default AppLayout;
