
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom"; 
import Lottie from "lottie-react";

import BookLogo from "../../../Assets/Animations/BookLogo.json";
import Notification from "../../../Assets/Icons/notfication.svg";
import checkout from "../../../Assets/Icons/checkout.svg";

import ThemeToggle from "../../themeToggle/ThemeToggle"; 
import { useAuth } from "../../../Context/AuthContext";

import "./navbar.css";
import useDropdown from '../../../Hooks/NavBar/useDropdown';
import NotificationBox from '../../NotificationBox/Notification';

const Navbar = () => {
  const { isAuthenticated, logout, role } = useAuth();
  const { isOpen: showDropdown, toggleDropdown, dropdownRef } = useDropdown();

  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate("/login");
  };


  return (
    <nav className='Navbar'>
      <div className='Navbar-logo' onClick={() => navigate("/")} > 
        <Lottie animationData={BookLogo} loop={true} className='Navbar-animation' />
      <div className='title'>
      <h2 className='bookly'>
       <Link to="/homePage"  className="bookly-link">
        Bookly
        </Link>
      </h2>
      </div>

      </div>

      {isAuthenticated && (
        <div className="navbar-links">
          <a href="/bookList" className="btn nav-btn">Library</a>
          <a href="/my_orders" className="btn nav-btn">My Orders</a>
          {role === "admin" && (
            <div className="dropdown-managment">
              <button className="btn nav-btn ">Management</button>
              <div className="dropdown-content styled-dropdown">
                <a href="/management">Order Management</a>
                <a href="/booksManagement">Book Management</a>
                <a href="/dashbored" className="btn nav-btn">Analytics</a>
              </div>
            </div>
          )}
        </div>
      )}

      <div className='left'>
        {!isAuthenticated ? (
          <>
            <a href="/login" className="btn nav-btn login-btn">Login</a>
            <a href="/register" className="btn nav-btn register-btn">Register</a>
          </>
        ) : (
          <>
            <a href="/cart" className="icon-btn">
              <img src={checkout} alt="Cart" />
            </a>
            <a className="icon-btn">
              <NotificationBox/>
            </a>
          </>
        )}

        <ThemeToggle />

        {isAuthenticated && (
          <div className="Navbar-profile" onClick={toggleDropdown} ref={dropdownRef}>
           <img
              src={theme === 'dark' ? emptypfpnight : emptypfp}
              alt="Profile"
              className="pro-pic"
            />

            {showDropdown && (
              <ul className="dropdown">
                <li>
                  <button className="dropdown-logout-btn" onClick={handleLogout}>Logout</button>
                </li>
              </ul>
            )}
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;
