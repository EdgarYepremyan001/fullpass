export default function admin({ next, router }) {
  let roles = JSON.parse(localStorage.getItem("roles"));
  if(roles && Object.values(roles).length && roles[0].name === 'moderator'){
    return router.push('/posts');
  }
  return next();
}
