# LeanPackageValidator GitHub Action

The LeanPackageValidator GitHub Action is utilising the [LeanPackage Validator](https://github.com/raphaelstolt/lean-package-validator), which can validate a 
project/micro-package for its `leanness`. A project/micro-package is considered `lean` when its common 
repository artifacts/dotfiles like `.editorconfig`, `/tests`, ... ,  won't be included in the release assets.

#### Usage
Check the Git repository's `.gitattribute` against a `.lpv` file in the Git repository under continuous integration.
A `.lpv` stores the glob pattern used for validating a `.gitattribute` file and should be committed in the Git repository
under continuous integration.

```yaml
... omitted job configuration
        strategy:
            fail-fast: true
            matrix:
                php:
                    - "8.1"
        steps:
            -   name: Check leanness of package
                uses: raphaelstolt/lean-package-validator-action@v<version>
                with:
                    php-version: "${{ matrix.php }}"
                    lpv-version: "3.0.0"
```

Check the Git repository's `.gitattribute` against a glob pattern e.g. for Python projects and have some more verbose
output.

```yaml
... omitted job configuration
        strategy:
            fail-fast: true
            matrix:
                php:
                    - "8.1"
        steps:
            -   name: Check leanness of package
                uses: raphaelstolt/lean-package-validator-action@v<version>
                with:
                    php-version: "${{ matrix.php }}"
                    lpv-version: "3.0.0"
                    glob-pattern: '{.*,*.rst,*.py[cod],dist/}'
                    verbose: true
```

#### License
This GitHub Action is licensed under the MIT license. Please see [LICENSE.md](LICENSE.md) for more details.

#### Changelog
Please see [CHANGELOG.md](CHANGELOG.md) for more details.
