import './Footer.css';
import instgram from "../../Assets/Icons/instgram.svg";
import facebook from "../../Assets/Icons/facebook.svg";
import tiktok from "../../Assets/Icons/tiktok.svg";
import { FiChevronRight } from 'react-icons/fi';

const Footer = () => {
  return (
    <footer className="footerr">
      <div className="container">
        <div className="footer-main">
          <div className="footer-about">
            <div className="footer-about-logo">
              <span>Bookly</span>
            </div>

            <p>
              Discover books you'll love. For every kind of reader. We help you preserve meaningful stories, connect with others, and explore knowledge timelessly.
            </p>

            <div className="social-icons-img">
              <a href="https://instagram.com/bookly" className="social-icons-image" target="_blank" rel="noreferrer">
                <img src={instgram} alt="Instagram" />
              </a>
              <a href="https://facebook.com/bookly" className="social-icons-image" target="_blank" rel="noreferrer">
                <img src={facebook} alt="Facebook" />
              </a>
              <a href="https://tiktok.com/@bookly" className="social-icons-image" target="_blank" rel="noreferrer">
                <img src={tiktok} alt="TikTok" />
              </a>
            </div>
          </div>

          <div className="footer-links">
            <div>
              <h4>Features</h4>
              <ul>
                <li><FiChevronRight className="icon" /> Recommendations</li>
                <li><FiChevronRight className="icon" /> Collections</li>
                <li><FiChevronRight className="icon" /> Wish List</li>
                <li><FiChevronRight className="icon" /> Notifications</li>
              </ul>
            </div>

            <div>
              <h4>Resources</h4>
              <ul>
                <li><FiChevronRight className="icon" /> Help Center</li>
                <li><FiChevronRight className="icon" /> Contact Us</li>
                <li><FiChevronRight className="icon" /> Privacy Policy</li>
                <li><FiChevronRight className="icon" /> Terms</li>
              </ul>
            </div>
          </div>
        </div>

        <div className="footer-bottom">
          <small>BOOK DISCOVERY PLATFORM</small><br />
        </div>
      </div>
    </footer>
  );
};

export default Footer;
