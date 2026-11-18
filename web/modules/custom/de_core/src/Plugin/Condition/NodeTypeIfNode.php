<?php

namespace Drupal\de_core\Plugin\Condition;


use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\node\Plugin\Condition\NodeType;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an overridden version of a 'Node Type' condition.
 *
 * @Condition(
 *     id = "node_type_if_node",
 *     label = @Translation("Node Bundle on page"),
 * )
 */
class NodeTypeIfNode extends ConditionPluginBase implements ContainerFactoryPluginInterface {

    /**
     * The current route match.
     */
    protected RouteMatchInterface $currentRouteMatch;

    /**
     * The entity manager.
     */
    protected EntityTypeManagerInterface $entityManager;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        $instance = new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
        );

        $instance->currentRouteMatch = $container->get('current_route_match');
        $instance->entityManager = $container->get('entity_type.manager');
        return $instance;
    }
    /**
     * {@inheritdoc}
     */
    public function buildConfigurationForm(array $form, FormStateInterface $form_state)
    {
        $form['only_apply_on_node_pages'] = [
            '#type' => 'markup',
            '#markup' => $this->t('<p>This only applies on node pages and is ignored on all other pages.</p>'),
        ];

        $options = [];
        $node_types = $this->entityManager->storage('node_type')->loadMultiple();
        foreach ($node_types as $type) {
            $options[$type->id()] = $type->label();
        }
        $form['bundles'] = [
            '#title' => $this->t('Node types'),
            '#type' => 'checkboxes',
            '#options' => $options,
            '#default_value' => $this->configuration['bundles'],
        ];

        return parent::buildConfigurationForm($form, $form_state);
    }
    /**
     * {@inheritdoc}
     */
    public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
        $this->configuration['bundles'] = array_filter($form_state->getValue('bundles'));
        parent::submitConfigurationForm($form, $form_state);
    }
    /**
     * {@inheritdoc}
     */
    public function summary() {
        if (count($this->configuration['bundles']) > 1) {
            $bundles = $this->configuration['bundles'];
            $last = array_pop($bundles);
            $bundles = implode(', ', $bundles);
            return $this->t('The node bundle is @bundles or @last', ['@bundles' => $bundles, '@last' => $last]);
        }
        $bundle = reset($this->configuration['bundles']);
        return $this->t('The node bundle is @bundle', ['@bundle' => $bundle]);
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate()
    {
        if ($this->currentRouteMatch->getRouteName() !== 'entity.node.canonical') {
            return !$this->isNegated();
        }
        $node = $this->currentRouteMatch->getParameter('node');
        if (empty($this->configuration['bundles']) && !$this->isNegated()) {
            return TRUE;
        }
        $node = $this->currentRouteMatch->getParameter('node');

        return !empty($this->configuration['bundles'][$node->getType()]);
    }

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return ['bundles' => []] + parent::defaultConfiguration();
    }

}
