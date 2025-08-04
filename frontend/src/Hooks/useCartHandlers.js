import useCart from './useUserCart';
import useDeleteCart from './useDeleteCart';
import useAddToCart from './useAddToCart';
import useUpdateCartQuantity from './useUpdateCartQuantity';
import useCheckout from './useCheckout';



const useCartHandlers = () => {
  const { cart, total, loading, error, setCart } = useCart();
  const { deleteCartItem, deleting } = useDeleteCart();
  const { handleAddToCart, loading: cartLoading, error: cartError } = useAddToCart();
  const { decreaseQuantity } = useUpdateCartQuantity();
  const { CheckoutCartItem, isLoading, error: checkoutError } = useCheckout();

  const handleCheckout = async () => {
    await CheckoutCartItem(() => {
      setCart([]);
    });
  };

  const handleIncrease = async (item) => {
    const result = await handleAddToCart(item.book.id, 1);

    if (result) {
      setCart(prev =>
        prev.map(ci =>
          ci.id === item.id ? { ...ci, quantity: ci.quantity + 1 } : ci
        )
      );
    } else {
      alert('Failed to add to cart');
    }
  };

 const handleQuantityChange = async (item) => {
  const updatedItem = await decreaseQuantity(item.book.id);

  if (updatedItem) {
    setCart(prev =>
      prev.map(ci =>
        ci.id === item.id ? { ...ci, quantity: ci.quantity - 1 } : ci
      )
    );
  } else {
    alert('Failed to decrease quantity');
  }
};


  const handleRemove = async (itemId) => {
    const result = await deleteCartItem(itemId);

    if (result) {
      setCart(prev => prev.filter(item => item.id !== itemId));
    }
  };

  return {
    cart,
    total,
    loading,
    error,
    deleting,
    cartLoading,
    cartError,
    isLoading,
    checkoutError,
    handleCheckout,
    handleIncrease,
    handleQuantityChange,
    handleRemove
  };
};

export default useCartHandlers;
