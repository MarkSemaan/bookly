 
import { Outlet } from "react-router-dom";
import Navbar from "../Navbar/Navbar";
import "./AppLayout.css"; 


const AppLayout = () => {
  return (
    <div className="layout-wrapper">
      <Navbar />
        <div className="main-content">
          <Outlet />
        </div>
    </div>
  );
};

export default AppLayout;
