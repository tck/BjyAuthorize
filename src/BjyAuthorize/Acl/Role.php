<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace BjyAuthorize\Acl;

use BjyAuthorize\Exception;
use Zend\Permissions\Acl\Role\RoleInterface;

/**
 * Base role object
 *
 * @author Ben Youngblood <bx.youngblood@gmail.com>
 */
class Role implements RoleInterface
{
    /**
     * @var string
     */
    protected $roleId;

    /**
     * @var RoleInterface
     */
    protected $parent = null;

    /**
     * @param string|null               $roleId
     * @param RoleInterface|string|null $parent
     */
    public function __construct($roleId = null, $parent = null)
    {
        $this->setRoleId($roleId);
        if (null !== $parent) {
            $this->setParent($parent);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param string $roleId
     *
     * @return self
     */
    public function setRoleId($roleId)
    {
        $this->roleId = (string) $roleId;

        return $this;
    }

    /**
     * @return RoleInterface|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param RoleInterface|string|null $parent
     *
     * @return self
     */
    public function setParent($parent)
    {
        if (is_string($parent)) {
            $parent = new Role($parent);
        } elseif (!($parent instanceof RoleInterface)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects either a string or Zend\Permissions\Acl\Role\RoleInterface '
                . 'instance; received "%s"',
                __METHOD__,
                (is_object($parent) ? get_class($parent) : gettype($parent))
            ));
        }

        $this->parent = $parent;

        return $this;
    }
}
