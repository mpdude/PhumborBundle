# Upgrading notes

## Upgrade from `jbouzekri/phumbor-bundle` 2.2.0 to `webfactory/phumbor-bundle` 3.0.0

* The bundle name changed to `\Webfactory\Bundle\PhumborBundle\WebfactoryPhumborBundle`
* Use the Symfony `config.yml` top-level key `webfactory_phumbor` instead of `jb_phumbor`
* DIC parameters `phumbor.url.builder_factory.class`, `phumbor.url.transformer.class` and `phumbor.twig.extension.class` can no longer be used to replace implementation classes.
* Service `Jb\Bundle\PhumborBundle\Transformer\BaseTransformer` is now named `Webfactory\Bundle\PhumborBundle\Transformer\BaseTransformer`
* Deprecated service aliases `phumbor.url.builder_factory`, `phumbor.url.transformer` and `phumbor.twig.extension` have been removed.
