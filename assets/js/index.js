const titleCommentsCocktails = document.querySelectorAll('.title-comments-cocktail');
const contentCategoryComment = document.querySelectorAll('.content-comments-cocktail');

const selectors = {
   '#link-addCocktail': '.link-addCocktail',
   '#link-addComment': '.link-addComment',
   '#link-deleteComment': '.link-deleteComment',
   '#link-editeCocktail': '.link-editeCocktail',
   '#link-deleteCocktail': '.link-deleteCocktail',
   '#link-register': '.link-register'
}

const toggleDisplayLink = (link, target) => {
   if (document.querySelector(link) && document.querySelector(target)) {
      document.querySelector(link).addEventListener('mouseenter', () => document.querySelector(target).classList.add('visible'));
      document.querySelector(link).addEventListener('mouseleave', () => document.querySelector(target).classList.remove('visible'));
   }
}

for (const key in selectors) {
   if (Object.hasOwnProperty.call(selectors, key)) toggleDisplayLink(key, selectors[key])
}

if (titleCommentsCocktails.length && contentCategoryComment.length) {
   for (let i = 0; i < titleCommentsCocktails.length; i++) {
      titleCommentsCocktails[i].addEventListener('click', () => {
         contentCategoryComment[i].classList.toggle('show');
      })
   }
}







