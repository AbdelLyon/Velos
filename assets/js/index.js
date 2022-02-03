const titleCommentsCocktails = document.querySelectorAll('.title-comments-cocktail');
const contentCategoryComment = document.querySelectorAll('.content-comments-cocktail');

const toggleLink = (link, target) => {
   if (document.querySelector(link) && document.querySelector(target)) {
      document.querySelector(link).addEventListener('mouseenter', () => document.querySelector(target).classList.add('visible'));
      document.querySelector(link).addEventListener('mouseleave', () => document.querySelector(target).classList.remove('visible'));
   }
}

toggleLink('#link-addCocktail', '.link-addCocktail');
toggleLink('#link-addComment', '.link-addComment');
toggleLink('#link-deleteComment', '.link-deleteComment');
toggleLink('#link-editeCocktail', '.link-editeCocktail');
toggleLink('#link-deleteCocktail', '.link-deleteCocktail');
toggleLink('#link-register', '.link-register');





if (titleCommentsCocktails && contentCategoryComment) {
   for (let i = 0; i < titleCommentsCocktails.length; i++) {
      titleCommentsCocktails[i].addEventListener('click', () => {
         contentCategoryComment[i].classList.toggle('show');
      })
   }
}







