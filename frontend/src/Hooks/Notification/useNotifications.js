import { useEffect, useState } from 'react';
import { fetchAllNotifications } from '../../Services/notification/notificationService';

const useNotifications = () => {
  const [notifications, setNotifications] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const getNotifications = async () => {
      try {
        const data = await fetchAllNotifications();
        setNotifications(data);
      } catch (error) {
        console.error('Error fetching notifications:', error);
      } finally {
        setLoading(false);
      }
    };

    getNotifications();
  }, []);

  return { notifications, loading };
};

export default useNotifications;
