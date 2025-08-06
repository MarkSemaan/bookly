import { useEffect, useState } from "react";
import { getBookById, updateBook } from "../../Services/bookService/bookManagmentService";
import { useNavigate, useParams } from "react-router-dom";

const useEditBook = () => {
  const { id } = useParams();
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
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [successMsg, setSuccessMsg] = useState(null);

  const increaseQuantity = () => setQuantity((q) => q + 1);
  const decreaseQuantity = () => setQuantity((q) => (q > 0 ? q - 1 : 0));
  const increasePrice = () => setPrice((p) => p + 1);
  const decreasePrice = () => setPrice((p) => (p > 0 ? p - 1 : 0));

  useEffect(() => {
    getBookById(id)
      .then((res) => {
        const book = res.data.payload;
        setTitle(book.title);
        setAuthor(book.author);
        setPublisher(book.publisher);
        setPublishedYear(book.published_year);
        setImageBase64(book.image);
        setQuantity(book.stock);
        setPrice(book.price);
        setCategoryId(book.category_id);
        setRating(book.rating);
        setDescription(book.description);
        setLoading(false);
      })
      .catch((err) => {
        setError("Failed to load book data");
        setLoading(false);
        console.error(err);
      });
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    setSuccessMsg(null);

    const payload = {
      title,
      author,
      publisher,
      published_year: Number(publishedYear),
      image: imageBase64,
      stock: quantity,
      price,
      category_id: Number(categoryId),
      rating,
      description,
      sold: 0,
      is_available: true,
    };

    try {
      await updateBook(id, payload);
      setSuccessMsg("Book updated successfully!");
      navigate("/booksManagement");
    } catch (err) {
      setError("Failed to update book.");
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

export default useEditBook;
