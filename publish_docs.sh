# checkout to the gh-pages branch
git checkout gh-pages

cd docs/

# install the plugins and build the static site
gitbook install && gitbook build

cd ../

# copy the static site files into the current directory.
cp -R docs/_book/* ./

# remove 'node_modules' and '_book' directory
git clean -fx node_modules
git clean -fx _book

# add all files
git add .

# commit
git commit -a -m "Update docs"

# push to the origin
git push origin gh-pages

# checkout to the master branch
git checkout master