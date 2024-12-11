// Get role selection and username input elements
const roleSelect = document.getElementById('role');
const usernameInput = document.getElementById('username');

// Add event listener for role selection change
roleSelect.addEventListener('change', function(event) {
  // Get the selected role
  const selectedRole = roleSelect.value;

  // 根据选择的身份设置用户名的显示文本
  if (selectedRole === '商家') {
    usernameInput.placeholder = '店名';
  } else {
    usernameInput.placeholder = '用户名';
  }
});
