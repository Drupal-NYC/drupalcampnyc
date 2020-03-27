<?php

namespace Drupal\de_core\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'Current user page' condition to enable a condition based in module selected status.
 *
 * @Condition(
 *   id = "current_user_page",
 *   label = @Translation("Current user page"),
 *   context = {
 *     "user" = @ContextDefinition("entity:user", required = TRUE , label = @Translation("user"))
 *   }
 * )
 *
 */
class CurrentUserPage extends ConditionPluginBase implements ContainerFactoryPluginInterface {

    /** @var AccountProxy */
    protected $currentUser;

    /** @var RouteMatchInterface */
    protected $currentRouteMatch;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('current_user'),
            $container->get('current_route_match')
        );

    }

    /**
     * Creates a new CurrentUserPage object.
     *
     * @param array $configuration
     *   The plugin configuration, i.e. an array with configuration values keyed
     *   by configuration option name. The special key 'context' may be used to
     *   initialize the defined contexts by setting it to an array of context
     *   values keyed by context names.
     * @param string $plugin_id
     *   The plugin_id for the plugin instance.
     * @param mixed $plugin_definition
     *   The plugin implementation definition.
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxy $current_user, RouteMatchInterface $current_route_match) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->currentUser = $current_user;
        $this->currentRouteMatch = $current_route_match;
    }

    /**
     * {@inheritdoc}
     */
    public function buildConfigurationForm(array $form, FormStateInterface $form_state) {

        $form['show_on_own_page'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('Only show block on the users profile page'),
            '#default_value' => $this->configuration['show_on_own_page'],
            '#description' => $this->t('Checking this limits the rendering of the block to only happen on the users own profile page.'),
        ];

        // @todo expand with the opposite option, only show on other users profile page.

        return parent::buildConfigurationForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
        $this->configuration['show_on_own_page'] = $form_state->getValue('show_on_own_page');
        parent::submitConfigurationForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return ['show_on_own_page' => FALSE] + parent::defaultConfiguration();
    }

    /**
     * Evaluates the condition and returns TRUE or FALSE accordingly.
     *
     * @return bool
     *   TRUE if the condition has been met, FALSE otherwise.
     */
    public function evaluate() {
        if (empty($this->configuration['show_on_own_page']) && !$this->isNegated()) {
            return TRUE;
        }

        // Not on the current users page.
        $route_name = $this->currentRouteMatch->getRouteName();
        if ($this->currentRouteMatch->getRouteName() !== 'entity.user.canonical') {
            return FALSE;
        }
        $user = $this->currentRouteMatch->getParameter('user');
        //$user = $this->getContextValue('user');
        if ($this->currentUser->id() !== $user->id()) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Provides a human readable summary of the condition's configuration.
     */
    public function summary()
    {
        if (!empty($this->getContextValue('show_on_own_page'))) {
            return t('Only showing on users own profile page.');
        }
        return NULL;
    }

}
