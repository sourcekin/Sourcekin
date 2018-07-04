namespace Sourcekin\User\Model {
    data UserId   = UserId deriving (Uuid);
    data EMail    = String;
    data UserName = String;
    data Password = String;
}

namespace Sourcekin\Content\Model {
    data DocumentId = DocumentId deriving(Uuid);
    data DocumentName       = String;
    data DocumentTitle      = String;
    data DocumentText       = String;

    data Key   = String deriving (FromString, ToString);
    data Value = String deriving( FromString, ToString);

    data DocumentMeta = DocumentMeta { Key $key, Value $value }
    deriving (FromArray, ToArray)
    where
        DocumentMeta:
            | strlen($key->toString()) === 0 => 'Empty meta key'
    ;
    data ContentName = String deriving (FromString, ToString);
    data ContentType = String deriving (FromString, ToString);
    data Index       = Index { int $index }
        deriving (FromScalar, ToScalar, Equals)
        where Index:
            | $index < 0 => 'Only positive integers are allowed';

    data ValueType = Text | Image | Video | Link | Reference deriving (Enum);
    data Field   = Field { Key $key, Value $value, ValueType $type } deriving (FromArray, ToArray, Equals);
    data Content = Content { DocumentId $owner, ContentName $name, ContentType $type, Index $index, ?Field[] $fields, ?Content[] $children }
        deriving (FromArray, ToArray, Equals)

}