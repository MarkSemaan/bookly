import { React, useState, useEffect } from 'react';
import axios from 'axios';
import './booksManagement.css';
import BookCard from '../../Components/bookPage/allBooks/bookCard/BookCard';

const BooksManagement = () => {
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(true);
    const [statusChange, setStatusChange] = useState(false);
    const [books, setBooks] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const booksPerPage = 8;

    const base_url = 'http://127.0.0.1:8000/api/v0.1';
    const fetch_url = '/admin/books';
    const delete_url = '/user/books/delete/';
    const token = localStorage.getItem('token');

    useEffect(() => {
        fetchBooks();
    }, [statusChange]);

    const handleFetchError = (error) => {
        if (error.response && error.response.data) {
            console.log('API Error:', error.response.data);
            setError(error.response.data.message || 'Failed to fetch books');
        } else {
            console.error('Error:', error);
            setError('Error occurred');
        }
        setLoading(false);
    };

    const fetchBooks = () => {
        setLoading(true);
        axios
            .get(base_url + fetch_url, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            })
            .then((res) => {
                let fetchedBooks = res.data.payload;
                fetchedBooks.sort((a, b) => b.id - a.id); // sort by newest
                setBooks(fetchedBooks);
                setLoading(false);
            })
            .catch((error) => handleFetchError(error));
    };
    const handleDelete = (book_id) => {
        const token = localStorage.getItem('token');
        const book = axios.post(`${base_url}${delete_url}${book_id}`, {}, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        }).then((res) => {
            let book = res.data.payload;
            setBooks(prev => prev.filter(book => book.id !== book_id));
            console.log(book);
        }).catch(error => console.log(error));
    }

    const indexOfLastBook = currentPage * booksPerPage;
    const indexOfFirstBook = indexOfLastBook - booksPerPage;
    const currentBooks = books.slice(indexOfFirstBook, indexOfLastBook);
    const totalPages = Math.ceil(books.length / booksPerPage);

    const handleNextPage = () => {
        if (currentPage < totalPages) setCurrentPage(currentPage + 1);
    };

    const handlePrevPage = () => {
        if (currentPage > 1) setCurrentPage(currentPage - 1);
    };

    return (
        <div className="books-management-wrapper">
            <h1>Books Management</h1>
            {loading ? (
                <p>Loading...</p>
            ) : error ? (
                <div className="error">{error}</div>
            ) : (
                <>
                    <div className="books-container">
                        {currentBooks.map((book) => (
                            <BookCard key={book.id} book={book} isAdminCard={true} onDelete={handleDelete} />
                        ))}
                    </div>
                    <div className="pagination-controls">
                        <button onClick={handlePrevPage} disabled={currentPage === 1}>
                            &#8592; Prev
                        </button>
                        <span>Page {currentPage} of {totalPages}</span>
                        <button onClick={handleNextPage} disabled={currentPage === totalPages}>
                            Next &#8594;
                        </button>
                    </div>
                </>
            )}
        </div>
    );
};

export default BooksManagement;
