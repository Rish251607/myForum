// JS for background:
function setTheme(theme) {
  if (theme === 'day') {
    document.body.style.backgroundColor = 'white';
    document.body.style.color = 'black';
  } else if (theme === 'night') {
    document.body.style.backgroundColor = '#333';
    document.body.style.color = 'white';
  }
}