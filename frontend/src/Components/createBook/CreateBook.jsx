import React from "react";
import useCategories from "../../Hooks/Categories/useCategories";
import MediaUpload from "../MediaUpload/MediaUpload";
import FormInput from "../Shared/Input/FormInput";
import useCreateBook from "../../Hooks/BookManagment/useCreateBook";
import "./createBook.css";

const CreateBook = () => {
  const { categories, loading: categoriesLoading } = useCategories();

  const {
    title, setTitle,
    author, setAuthor,
    publisher, setPublisher,
    publishedYear, setPublishedYear,
    imageBase64, setImageBase64,
    quantity,setQuantity, increaseQuantity, decreaseQuantity,
    price, setPrice,increasePrice, decreasePrice,
    categoryId, setCategoryId,
    rating, setRating,
    description, setDescription,
    loading, error, successMsg,
    handleSubmit
  } = useCreateBook();

  const stars = [1, 2, 3, 4, 5];

  return (
    <form className="create-book-form" onSubmit={handleSubmit}>
      <h2>Create Book</h2>


      <div className="form-row">
        <div className="form-group">
          <label className="label">Title</label>
          <FormInput
            type="text"
            name="title"
            hint="e.g. The Power of Stillness"
            required
            onChangeListener={(e) => setTitle(e.target.value)}
            value={title}
          />
        </div>
        <div className="form-group">
          <label className="label">Author</label>
          <FormInput
            type="text"
            name="author"
            hint="e.g. John Manson"
            required
            onChangeListener={(e) => setAuthor(e.target.value)}
            value={author}
          />
        </div>
      </div>

     
      <div className="form-row">
        <div className="form-group">
          <label className="label">Published Year</label>
          <div className="control-box boxed-group">
            <select
              name="published_year"
              value={publishedYear}
              onChange={(e) => setPublishedYear(e.target.value)}
              className="year-select"
              required
            >
              <option value="">Select a year</option>
              {[...Array(100)].map((_, i) => {
                const year = new Date().getFullYear() - i;
                return <option key={year} value={year}>{year}</option>;
              })}
            </select>
          </div>
        </div>

        <div className="form-group">
          <label className="label">Publisher</label>
          <FormInput
            type="text"
            name="publisher"
            hint="e.g. HarperCollins"
            onChangeListener={(e) => setPublisher(e.target.value)}
            value={publisher}
          />
        </div>
      </div>


      <div className="form-row">
        <div className="form-group">
          <label className="label">Upload Image</label>
          <MediaUpload setImageBase64={setImageBase64} />
        </div>
        <div className="form-group">
          <label className="label">Quantity</label>
          <div className="quantity-box">
            <button type="button" className="quantity-btn" onClick={decreaseQuantity}>-</button>
            <span className="quantity-count">{quantity}</span>
            <button type="button" className="quantity-btn" onClick={increaseQuantity}>+</button>
          </div>
        </div>
      </div>

 
      <div className="form-row gap">
        <div className="form-group">
          <label className="label">Price ($)</label>
          <div className="control-box boxed-group">
            <button type="button" onClick={decreasePrice}>-</button>
            <input
              type="number"
              value={price}
              onChange={(e) => setPrice(Number(e.target.value))}
              className="control-input"
              min="0"
              placeholder="19.99"
            />
            <button type="button" onClick={increasePrice}>+</button>
          </div>
        </div>

        <div className="form-group">
          <label className="label">Category</label>
          <select
            value={categoryId}
            onChange={(e) => setCategoryId(e.target.value)}
            className="control-input-quality boxed-group"
            disabled={categoriesLoading}
            required
          >
            <option value="">Select Category</option>
            {categories.map((cat) => (
              <option key={cat.id} value={cat.id}>{cat.name}</option>
            ))}
          </select>
        </div>

        <div className="form-group">
          <label className="label">Rating</label>
          <div className="starr-box">
            {stars.map((star) => (
              <span
                key={star}
                onClick={() => setRating(star)}
                className={`starr ${star <= rating ? "filled" : ""}`}
              >
                &#9733;
              </span>
            ))}
          </div>
        </div>
      </div>

     
      <div className="form-group full-width">
        <label className="label">Description</label>
        <textarea
          placeholder="e.g. This book explores the art of slowing down in a fast-paced world.."
          value={description}
          onChange={(e) => setDescription(e.target.value)}
          rows={6}
          className="big-textarea"
        />
      </div>

    
      {error && <p className="error">{error}</p>}
      {successMsg && <p className="success">{successMsg}</p>}

      <button type="submit" disabled={loading} className="btncreate">
        {loading ? "Creating..." : "Create Book"}
      </button>
    </form>
  );
};

export default CreateBook;
