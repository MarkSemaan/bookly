import React from 'react';
import instgram from "../../Assets/Icons/instgram.svg";
import facebook from "../../Assets/Icons/facebook.svg";
import tiktok from "../../Assets/Icons/tiktok.svg";
import "./Footer.css";

const Footer = () => {
  return (
    <footer className="footer">
      <div className="footer-left">
        <div className="footer-top-row">
          <div className="footer-branding">
            <h2 className="footer-title">Bookly</h2>
            <p className="footer-des">
              Discover books you'll love. For every kind of reader.
            </p>
          </div>

          <div className="contact-info">
            <p className="footer-question">Have questions?</p>
            <div className="footer-contact">
              <p className="footer-phone">Phone: +961 76 123 456</p>
              <p className="footer-email">
                Reach out at <a href="mailto:support@bookly.com">support@bookly.com</a>
              </p>
            </div>
          </div>
        </div>
      </div>

      <div className="footer-middle">
        <p className="footer-middle-title">Stay in the loop</p>
        <p className="footer-middle-des">
          Subscribe to get book recommendations and updates
        </p>
        <form className="footer-subscribe">
          <input type="email" placeholder="Enter your email" required />
          <button type="submit">Subscribe</button>
        </form>
      </div>


      <div className="footer-right">
        <p className="footer-social-title">Get in touch</p>
        <div className="footer-socials">
          <a
            href="https://instagram.com/bookly"
            target="_blank"
            rel="noreferrer"
            className="social-link"
          >
            <img src={instgram} alt="Instagram" />
            <span>Instagram</span>
          </a>
          <a
            href="https://facebook.com/bookly"
            target="_blank"
            rel="noreferrer"
            className="social-link"
          >
            <img src={facebook} alt="Facebook" />
            <span>Facebook</span>
          </a>
          <a
            href="https://tiktok.com/@bookly"
            target="_blank"
            rel="noreferrer"
            className="social-link"
          >
            <img src={tiktok} alt="TikTok" />
            <span>TikTok</span>
          </a>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
