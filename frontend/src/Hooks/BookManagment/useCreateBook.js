import { useState } from "react";
import { createBook } from "../../Services/bookService/bookManagmentService";
import { useNavigate } from "react-router-dom";

const useCreateBook = () => {
  const navigate = useNavigate();

  const [title, setTitle] = useState("");
  const [author, setAuthor] = useState("");
  const [publisher, setPublisher] = useState("");
  const [publishedYear, setPublishedYear] = useState("");
  const [imageBase64, setImageBase64] = useState("");
  const [quantity, setQuantity] = useState(0);
  const [price, setPrice] = useState(0);
  const [categoryId, setCategoryId] = useState("");
  const [rating, setRating] = useState(0);
  const [description, setDescription] = useState("");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [successMsg, setSuccessMsg] = useState(null);

  const increaseQuantity = () => setQuantity(q => q + 1);
  const decreaseQuantity = () => setQuantity(q => (q > 0 ? q - 1 : 0));
  const increasePrice = () => setPrice(p => p + 1);
  const decreasePrice = () => setPrice(p => (p > 0 ? p - 1 : 0));

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    setSuccessMsg(null);

    const payload = {
      title,
      author,
      publisher,
      published_year: publishedYear ? Number(publishedYear) : null,
      image: imageBase64,
      stock: quantity,
      price,
      category_id: categoryId ? Number(categoryId) : null,
      rating,
      description,
      sold: 0,
      is_available: true,
    };

    try {
      await createBook(payload);
      setSuccessMsg("Book created successfully!");
      navigate("/booksManagement");
    } catch (err) {
      setError("Failed to create book. Please check inputs.");
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  return {
    title, setTitle,
    author, setAuthor,
    publisher, setPublisher,
    publishedYear, setPublishedYear,
    imageBase64, setImageBase64,
    quantity, increaseQuantity, decreaseQuantity,
    price,setPrice, increasePrice, decreasePrice,
    categoryId, setCategoryId,
    rating, setRating,
    description, setDescription,
    loading, error, successMsg,
    handleSubmit,
  };
};

export default useCreateBook;
